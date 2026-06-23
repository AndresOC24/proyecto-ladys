<?php

namespace App\Http\Controllers;

use App\Jobs\AnalizarRegistroJob;
use App\Models\Bitacora;
use App\Models\ParametroControl;
use App\Models\Revision;
use App\Models\Role;
use App\Models\User;
use App\Notifications\ResultadoVerificacion;
use App\Services\BitacoraService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total'       => User::whereHas('role', fn($q) => $q->whereIn('nombre', ['pasajero','conductora']))->count(),
            'verificadas' => User::where('estado_verificacion', 'verificada')->count(),
            'analizando'  => User::where('estado_verificacion', 'analizando')->count(),
            'pendientes'  => User::where('estado_verificacion', 'pendiente')->count(),
            'rechazadas'  => User::where('estado_verificacion', 'rechazada')->count(),
            'pasajeras'   => User::whereHas('role', fn($q) => $q->where('nombre', 'pasajero'))->count(),
            'conductoras' => User::whereHas('role', fn($q) => $q->where('nombre', 'conductora'))->count(),
        ];

        $recientes = User::with('role')
            ->whereHas('role', fn($q) => $q->whereIn('nombre', ['pasajero','conductora']))
            ->latest()
            ->take(5)
            ->get();

        // Datos para la gráfica: registros por día en los últimos 7 días
        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d/m');
            $chartData[]   = User::whereDate('created_at', $date->toDateString())
                ->whereHas('role', fn($q) => $q->whereIn('nombre', ['pasajero','conductora']))
                ->count();
        }

        return view('admin.dashboard', compact('stats', 'recientes', 'chartLabels', 'chartData'));
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

        if ($request->filled('desde')) {
            $query->where('created_at', '>=', \Carbon\Carbon::parse($request->desde)->startOfDay());
        }

        if ($request->filled('hasta')) {
            $query->where('created_at', '<=', \Carbon\Carbon::parse($request->hasta)->endOfDay());
        }

        $usuarias = $query->latest()->paginate(15)->withQueryString();

        return view('admin.usuarias', compact('usuarias'));
    }

    public function exportarCsv(Request $request): StreamedResponse
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
        if ($request->filled('desde')) {
            $query->where('created_at', '>=', \Carbon\Carbon::parse($request->desde)->startOfDay());
        }
        if ($request->filled('hasta')) {
            $query->where('created_at', '<=', \Carbon\Carbon::parse($request->hasta)->endOfDay());
        }

        $usuarias = $query->latest()->get();
        $filename = 'usuarias_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($usuarias) {
            $handle = fopen('php://output', 'w');
            // BOM para que Excel abra con UTF-8 correctamente
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Nombre', 'Email', 'N° Carnet', 'Teléfono', 'Rol', 'Estado', 'Activa', 'Registrada']);
            foreach ($usuarias as $u) {
                fputcsv($handle, [
                    $u->name,
                    $u->email,
                    $u->numero_carnet,
                    $u->telefono,
                    $u->role?->nombre,
                    $u->estado_verificacion,
                    $u->activa ? 'Sí' : 'No',
                    $u->created_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function ver(User $usuaria)
    {
        return view('admin.usuaria-detalle', [
            'u' => $usuaria->load('role', 'vehiculo', 'revisiones.administrador', 'registros'),
        ]);
    }

    public function imprimir(User $usuaria)
    {
        return view('admin.usuaria-imprimir', [
            'u' => $usuaria->load('role', 'vehiculo', 'revisiones.administrador'),
        ]);
    }

    public function aprobar(User $usuaria): RedirectResponse
    {
        $usuaria->update([
            'estado_verificacion' => 'verificada',
            'resultado_analisis' => $this->actualizarHistorialJson($usuaria, 'aprobada'),
            'analizado_en' => now(),
        ]);

        Revision::create([
            'user_id'          => $usuaria->id,
            'administrador_id' => auth()->id(),
            'decision'         => 'aprobada',
        ]);

        BitacoraService::registrar('aprobar_usuaria', 'User', $usuaria->id, [
            'nombre' => $usuaria->name,
        ]);

        try {
            $usuaria->notify(new ResultadoVerificacion('verificada', null, 'administrador'));
        } catch (\Throwable) { /* no bloquear si el mail falla */ }

        return back()->with('status', 'Usuaria aprobada manualmente.');
    }

    public function rechazar(Request $request, User $usuaria): RedirectResponse
    {
        $request->validate(['motivo' => ['required', 'string', 'max:500']]);

        $usuaria->update([
            'estado_verificacion' => 'rechazada',
            'resultado_analisis' => $this->actualizarHistorialJson($usuaria, 'rechazada', $request->motivo, [
                'motivo_rechazo' => $request->motivo,
            ]),
            'analizado_en' => now(),
        ]);

        Revision::create([
            'user_id'          => $usuaria->id,
            'administrador_id' => auth()->id(),
            'decision'         => 'rechazada',
            'observacion'      => $request->motivo,
        ]);

        BitacoraService::registrar('rechazar_usuaria', 'User', $usuaria->id, [
            'nombre' => $usuaria->name,
            'motivo' => $request->motivo,
        ]);

        try {
            $usuaria->notify(new ResultadoVerificacion('rechazada', $request->motivo, 'administrador'));
        } catch (\Throwable) { /* no bloquear si el mail falla */ }

        return back()->with('status', 'Usuaria rechazada.');
    }

    public function reanalizar(User $usuaria): RedirectResponse
    {
        $usuaria->update([
            'estado_verificacion' => 'analizando',
            'resultado_analisis'  => $this->actualizarHistorialJson($usuaria, 'reanalisis'),
        ]);

        Revision::create([
            'user_id'          => $usuaria->id,
            'administrador_id' => auth()->id(),
            'decision'         => 'reanalisis',
        ]);

        BitacoraService::registrar('reanalizar_usuaria', 'User', $usuaria->id, [
            'nombre' => $usuaria->name,
        ]);

        AnalizarRegistroJob::dispatch($usuaria->id);
        return back()->with('status', 'Reanálisis encolado.');
    }

    private function actualizarHistorialJson(User $usuaria, string $accion, ?string $motivo = null, array $extra = []): array
    {
        $resultado = $usuaria->resultado_analisis ?? [];
        $historial = $resultado['historial_revisiones'] ?? [];

        $historial[] = array_filter([
            'accion' => $accion,
            'admin'  => auth()->user()->email,
            'fecha'  => now()->toDateTimeString(),
            'motivo' => $motivo,
        ], fn ($v) => $v !== null);

        return array_merge($resultado, $extra, ['historial_revisiones' => $historial]);
    }

    public function desactivar(User $usuaria): RedirectResponse
    {
        if ($usuaria->id === auth()->id()) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $usuaria->update(['activa' => false]);

        BitacoraService::registrar('desactivar_usuaria', 'User', $usuaria->id, [
            'nombre' => $usuaria->name,
        ]);

        return back()->with('status', 'Usuaria desactivada. No podrá iniciar sesión.');
    }

    public function reactivar(User $usuaria): RedirectResponse
    {
        $usuaria->update(['activa' => true]);

        BitacoraService::registrar('reactivar_usuaria', 'User', $usuaria->id, [
            'nombre' => $usuaria->name,
        ]);

        return back()->with('status', 'Usuaria reactivada.');
    }

    public function eliminar(User $usuaria): RedirectResponse
    {
        if ($usuaria->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $paths = array_filter([
            $usuaria->carnet_anverso_path,
            $usuaria->carnet_reverso_path,
            $usuaria->selfie_path,
            $usuaria->licencia_path,
        ]);

        foreach ($paths as $path) {
            Storage::disk('local')->delete($path);
        }

        $nombre = $usuaria->name;
        $id = $usuaria->id;

        $usuaria->delete();

        BitacoraService::registrar('eliminar_usuaria', 'User', $id, [
            'nombre' => $nombre,
        ]);

        return redirect()
            ->route('admin.usuarias')
            ->with('status', "Cuenta de «{$nombre}» eliminada permanentemente.");
    }

    public function asignarRol(Request $request, User $usuaria): RedirectResponse
    {
        $nombres = Role::pluck('nombre')->all();
        $datos = $request->validate([
            'rol' => ['required', 'string', Rule::in($nombres)],
        ]);

        if ($usuaria->id === auth()->id() && $datos['rol'] !== Role::ADMINISTRADOR) {
            return back()->with('error', 'No puedes quitarte tu propio rol de administrador.');
        }

        $rolAnterior = $usuaria->role?->nombre;
        $rol = Role::where('nombre', $datos['rol'])->firstOrFail();
        $usuaria->update(['role_id' => $rol->id]);

        BitacoraService::registrar('cambiar_rol', 'User', $usuaria->id, [
            'nombre'       => $usuaria->name,
            'rol_anterior' => $rolAnterior,
            'rol_nuevo'    => $datos['rol'],
        ]);

        return back()->with('status', "Rol actualizado a «{$datos['rol']}».");
    }

    public function imagen(User $usuaria, string $tipo): StreamedResponse
    {
        $path = match ($tipo) {
            'anverso' => $usuaria->carnet_anverso_path,
            'reverso'  => $usuaria->carnet_reverso_path,
            'selfie'   => $usuaria->selfie_path,
            'licencia' => $usuaria->licencia_path,
            default    => abort(404),
        };

        abort_unless($path && Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path);
    }

    // --- Bitácora ---

    public function revision(Request $request)
    {
        $query = User::with('role')
            ->whereHas('role', fn ($q) => $q->whereIn('nombre', [Role::PASAJERO, Role::CONDUCTORA]))
            ->where('estado_verificacion', 'pendiente')
            ->oldest();

        if ($request->filled('rol')) {
            $query->whereHas('role', fn ($q) => $q->where('nombre', $request->rol));
        }

        $pendientes = $query->paginate(20)->withQueryString();
        $total = User::where('estado_verificacion', 'pendiente')->count();

        return view('admin.revision', compact('pendientes', 'total'));
    }

    public function bitacora(Request $request)
    {
        $query = Bitacora::with('usuario')->latest();

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('usuario', fn($x) => $x->where('name', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%"));
        }

        if ($request->filled('desde')) {
            $query->where('created_at', '>=', \Carbon\Carbon::parse($request->desde)->startOfDay());
        }

        if ($request->filled('hasta')) {
            $query->where('created_at', '<=', \Carbon\Carbon::parse($request->hasta)->endOfDay());
        }

        $registros = $query->paginate(30)->withQueryString();
        $acciones  = Bitacora::distinct()->orderBy('accion')->pluck('accion');

        return view('admin.bitacora', compact('registros', 'acciones'));
    }

    // --- Parámetros de control ---

    public function parametros()
    {
        $parametros = \App\Models\ParametroControl::orderBy('tipo_documento')->orderBy('nombre_parametro')->get();
        return view('admin.parametros', compact('parametros'));
    }

    public function toggleParametro(ParametroControl $parametro): RedirectResponse
    {
        $parametro->update(['es_bloqueante' => ! $parametro->es_bloqueante]);

        BitacoraService::registrar('toggle_parametro', 'ParametroControl', $parametro->id, [
            'nombre'        => $parametro->nombre_parametro,
            'es_bloqueante' => $parametro->es_bloqueante,
        ]);

        return back()->with('status', "Parámetro «{$parametro->nombre_parametro}» actualizado.");
    }

    public function editarParametro(ParametroControl $parametro)
    {
        return view('admin.parametro-editar', compact('parametro'));
    }

    public function actualizarParametro(Request $request, ParametroControl $parametro): RedirectResponse
    {
        $datos = $request->validate([
            'tipo_documento'  => ['required', 'in:cedula,licencia'],
            'nombre_parametro'=> ['required', 'string', 'max:100'],
            'categoria'       => ['required', 'in:campo_requerido,vigencia,formato,coherencia'],
            'es_bloqueante'   => ['boolean'],
        ]);

        $anterior = $parametro->toArray();
        $parametro->update($datos);

        BitacoraService::registrar('editar_parametro', 'ParametroControl', $parametro->id, [
            'anterior' => $anterior,
            'nuevo'    => $datos,
        ]);

        return redirect()->route('admin.parametros')->with('status', "Parámetro «{$parametro->nombre_parametro}» actualizado.");
    }

    public function crearParametroForm()
    {
        return view('admin.parametro-crear');
    }

    public function guardarParametro(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'tipo_documento'   => ['required', 'in:cedula,licencia'],
            'nombre_parametro' => ['required', 'string', 'max:100'],
            'categoria'        => ['required', 'in:campo_requerido,vigencia,formato,coherencia'],
            'es_bloqueante'    => ['boolean'],
        ]);
        $datos['es_bloqueante'] = $request->boolean('es_bloqueante');

        $parametro = ParametroControl::create($datos);

        BitacoraService::registrar('crear_parametro', 'ParametroControl', $parametro->id, $datos);

        return redirect()->route('admin.parametros')->with('status', "Parámetro «{$parametro->nombre_parametro}» creado.");
    }

    public function eliminarParametro(ParametroControl $parametro): RedirectResponse
    {
        $nombre = $parametro->nombre_parametro;
        $id = $parametro->id;
        $parametro->delete();

        BitacoraService::registrar('eliminar_parametro', 'ParametroControl', $id, ['nombre' => $nombre]);

        return redirect()->route('admin.parametros')->with('status', "Parámetro «{$nombre}» eliminado.");
    }

    // --- Gestión de administradoras ---

    public function administradoras()
    {
        $admins = User::with('role')
            ->whereHas('role', fn ($q) => $q->where('nombre', Role::ADMINISTRADOR))
            ->latest()
            ->get();

        return view('admin.administradoras', compact('admins'));
    }

    public function crearAdminForm()
    {
        return view('admin.admin-crear');
    }

    public function guardarAdmin(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $rol = Role::where('nombre', Role::ADMINISTRADOR)->firstOrFail();

        $admin = User::create([
            'name'                => $datos['name'],
            'email'               => $datos['email'],
            'password'            => Hash::make($datos['password']),
            'role_id'             => $rol->id,
            'activa'              => true,
            'estado_verificacion' => 'verificada',
        ]);

        BitacoraService::registrar('crear_administradora', 'User', $admin->id, [
            'nombre' => $admin->name,
            'email'  => $admin->email,
        ]);

        return redirect()->route('admin.administradoras')->with('status', "Administradora «{$admin->name}» creada.");
    }
}
