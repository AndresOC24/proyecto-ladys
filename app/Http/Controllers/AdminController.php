<?php

namespace App\Http\Controllers;

use App\Jobs\AnalizarRegistroJob;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total' => User::whereHas('role', fn($q) => $q->whereIn('nombre', ['pasajero','conductora']))->count(),
            'verificadas' => User::where('estado_verificacion', 'verificada')->count(),
            'analizando' => User::where('estado_verificacion', 'analizando')->count(),
            'pendientes' => User::where('estado_verificacion', 'pendiente')->count(),
            'rechazadas' => User::where('estado_verificacion', 'rechazada')->count(),
        ];

        $recientes = User::with('role')
            ->whereHas('role', fn($q) => $q->whereIn('nombre', ['pasajero','conductora']))
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recientes'));
    }

    public function usuarias(Request $request)
    {
        $query = User::with('role')
            ->whereHas('role', fn($q) => $q->whereIn('nombre', ['pasajero','conductora']));

        if ($request->filled('estado')) {
            $query->where('estado_verificacion', $request->estado);
        }

        if ($request->filled('rol')) {
            $query->whereHas('role', fn($q) => $q->where('nombre', $request->rol));
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(fn($x) => $x->where('name', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
                ->orWhere('numero_carnet', 'like', "%{$q}%"));
        }

        $usuarias = $query->latest()->paginate(15)->withQueryString();

        return view('admin.usuarias', compact('usuarias'));
    }

    public function ver(User $usuaria)
    {
        return view('admin.usuaria-detalle', ['u' => $usuaria->load('role')]);
    }

    public function aprobar(User $usuaria): RedirectResponse
    {
        $usuaria->update([
            'estado_verificacion' => 'verificada',
            'resultado_analisis' => $this->registrarRevision($usuaria, 'aprobada'),
            'analizado_en' => now(),
        ]);

        return back()->with('status', 'Usuaria aprobada manualmente.');
    }

    public function rechazar(Request $request, User $usuaria): RedirectResponse
    {
        $request->validate(['motivo' => ['required', 'string', 'max:500']]);

        $usuaria->update([
            'estado_verificacion' => 'rechazada',
            'resultado_analisis' => $this->registrarRevision($usuaria, 'rechazada', $request->motivo, [
                'motivo_rechazo' => $request->motivo,
            ]),
            'analizado_en' => now(),
        ]);

        return back()->with('status', 'Usuaria rechazada.');
    }

    public function reanalizar(User $usuaria): RedirectResponse
    {
        $usuaria->update([
            'resultado_analisis' => $this->registrarRevision($usuaria, 'reanalisis'),
        ]);

        AnalizarRegistroJob::dispatch($usuaria->id);
        return back()->with('status', 'Reanálisis encolado.');
    }

    /**
     * Añade una entrada al histórico de revisiones sin perder las anteriores.
     *
     * @param  array<string,mixed>  $extra  Claves adicionales a fusionar en resultado_analisis.
     * @return array<string,mixed>          Nuevo resultado_analisis listo para persistir.
     */
    private function registrarRevision(User $usuaria, string $accion, ?string $motivo = null, array $extra = []): array
    {
        $resultado = $usuaria->resultado_analisis ?? [];
        $historial = $resultado['historial_revisiones'] ?? [];

        $historial[] = array_filter([
            'accion' => $accion,
            'admin' => auth()->user()->email,
            'fecha' => now()->toDateTimeString(),
            'motivo' => $motivo,
        ], fn ($v) => $v !== null);

        return array_merge($resultado, $extra, ['historial_revisiones' => $historial]);
    }

    public function imagen(User $usuaria, string $tipo): StreamedResponse
    {
        $path = match ($tipo) {
            'anverso' => $usuaria->carnet_anverso_path,
            'reverso' => $usuaria->carnet_reverso_path,
            'selfie' => $usuaria->selfie_path,
            default => abort(404),
        };

        abort_unless($path && Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path);
    }
}