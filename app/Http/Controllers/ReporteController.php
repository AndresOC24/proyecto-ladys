<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReporteController extends Controller
{
    /** Estados de verificación considerados en los reportes. */
    private const ESTADOS = ['verificada', 'rechazada', 'pendiente', 'analizando'];

    public function index(Request $request)
    {
        [$desde, $hasta] = $this->rango($request);

        return view('admin.reportes', $this->datos($desde, $hasta));
    }

    public function exportar(Request $request, string $formato)
    {
        [$desde, $hasta] = $this->rango($request);
        $datos = $this->datos($desde, $hasta);
        $nombre = 'reporte_'.$desde->format('Ymd').'-'.$hasta->format('Ymd');

        return match ($formato) {
            'pdf' => Pdf::loadView('admin.reportes-pdf', $datos)
                ->setPaper('a4')
                ->download($nombre.'.pdf'),
            'excel' => response(view('admin.reportes-excel', $datos)->render(), 200, [
                'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="'.$nombre.'.xls"',
            ]),
            default => abort(404),
        };
    }

    /** Resuelve el rango de fechas (por defecto, el mes en curso). */
    private function rango(Request $request): array
    {
        $request->validate([
            'desde' => ['nullable', 'date'],
            'hasta' => ['nullable', 'date', 'after_or_equal:desde'],
        ]);

        $desde = $request->filled('desde')
            ? Carbon::parse($request->desde)->startOfDay()
            : now()->startOfMonth();
        $hasta = $request->filled('hasta')
            ? Carbon::parse($request->hasta)->endOfDay()
            : now()->endOfDay();

        return [$desde, $hasta];
    }

    /** Solo cuentan como "usuarias" las pasajeras y conductoras (no admins). */
    private function baseQuery()
    {
        return User::whereHas('role', fn ($q) => $q->whereIn('nombre', ['pasajero', 'conductora']));
    }

    /** Conteo por estado a partir de una consulta base. */
    private function conteoPorEstado($query): array
    {
        $conteo = [];
        foreach (self::ESTADOS as $estado) {
            $conteo[$estado] = (clone $query)->where('estado_verificacion', $estado)->count();
        }
        return $conteo;
    }

    /** Tasa de rechazo sobre los registros ya decididos (excluye "analizando"). */
    private function tasaRechazo(array $porEstado): array
    {
        $decididas = ($porEstado['verificada'] ?? 0) + ($porEstado['rechazada'] ?? 0) + ($porEstado['pendiente'] ?? 0);
        $rechazadas = $porEstado['rechazada'] ?? 0;

        return [
            'rechazadas' => $rechazadas,
            'decididas' => $decididas,
            'tasa' => $decididas > 0 ? round($rechazadas / $decididas * 100, 1) : 0.0,
        ];
    }

    /** Calcula todos los datos que comparten la vista y las exportaciones. */
    private function datos(Carbon $desde, Carbon $hasta): array
    {
        // Reporte de verificaciones (global, histórico)
        $verificaciones = $this->conteoPorEstado($this->baseQuery());
        $totalGlobal = array_sum($verificaciones);

        // Reporte por periodo (registros creados en el rango)
        $periodoQuery = $this->baseQuery()->whereBetween('created_at', [$desde, $hasta]);
        $periodoPorEstado = $this->conteoPorEstado($periodoQuery);
        $totalPeriodo = array_sum($periodoPorEstado);
        $usuariasPeriodo = $this->baseQuery()
            ->with('role')
            ->whereBetween('created_at', [$desde, $hasta])
            ->latest()
            ->get();

        // Reporte de tasa de rechazo (global y del periodo)
        $tasaGlobal = $this->tasaRechazo($verificaciones);
        $tasaPeriodo = $this->tasaRechazo($periodoPorEstado);

        return [
            'estados' => self::ESTADOS,
            'desde' => $desde,
            'hasta' => $hasta,
            'verificaciones' => $verificaciones,
            'totalGlobal' => $totalGlobal,
            'periodoPorEstado' => $periodoPorEstado,
            'totalPeriodo' => $totalPeriodo,
            'usuariasPeriodo' => $usuariasPeriodo,
            'tasaGlobal' => $tasaGlobal,
            'tasaPeriodo' => $tasaPeriodo,
            'generadoEn' => now(),
        ];
    }
}
