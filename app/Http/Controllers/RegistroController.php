<?php

namespace App\Http\Controllers;

use App\Jobs\AnalizarRegistroJob;
use App\Models\Documento;
use App\Models\RegistroVerificacion;
use App\Models\Role;
use App\Models\User;
use App\Services\BitacoraService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class RegistroController extends Controller
{
    private const SESSION_DATOS = 'registro.datos';
    private const SESSION_CARNET = 'registro.carnet';
    private const SESSION_SELFIE = 'registro.selfie';
    private const SESSION_LICENCIA = 'registro.licencia';
    private const SESSION_VEHICULO = 'registro.vehiculo';

    public function mostrarDatos()
    {
        return view('auth.register');
    }

    public function guardarDatos(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['required', 'string', 'max:20'],
            'fecha_nacimiento' => ['required', 'date', 'before:-18 years'],
            'numero_carnet' => ['required', 'string', 'max:20', Rule::unique('users', 'numero_carnet')],
            'rol' => ['required', 'in:pasajero,conductora'],
        ], [
            'fecha_nacimiento.before' => 'Debes ser mayor de 18 años para registrarte.',
            'numero_carnet.unique'    => 'Este número de carnet ya está registrado en el sistema. Si eres tú, usa la opción de reenvío de documentos.',
        ]);

        $request->session()->put(self::SESSION_DATOS, $datos);

        return redirect()->route('registro.carnet');
    }

    public function mostrarCarnet(Request $request)
    {
        if (! $request->session()->has(self::SESSION_DATOS)) {
            return redirect()->route('register');
        }
        return view('auth.registro-carnet');
    }

    public function guardarCarnet(Request $request): RedirectResponse
    {
        if (! $request->session()->has(self::SESSION_DATOS)) {
            return redirect()->route('register');
        }

        $request->validate([
            'anverso' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'reverso' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $tmpDir = "carnets-tmp/".$request->session()->getId();
        $pathAnv = $request->file('anverso')->storeAs($tmpDir, 'anverso.jpg', 'local');
        $pathRev = $request->file('reverso')->storeAs($tmpDir, 'reverso.jpg', 'local');

        $request->session()->put(self::SESSION_CARNET, [
            'anverso' => $pathAnv,
            'reverso' => $pathRev,
        ]);

        return redirect()->route('registro.selfie');
    }

    public function mostrarSelfie(Request $request)
    {
        if (! $request->session()->has(self::SESSION_DATOS) ||
            ! $request->session()->has(self::SESSION_CARNET)) {
            return redirect()->route('register');
        }
        return view('auth.registro-selfie');
    }

    public function guardarSelfie(Request $request): RedirectResponse
    {
        $datos = $request->session()->get(self::SESSION_DATOS);
        $carnet = $request->session()->get(self::SESSION_CARNET);

        if (! $datos || ! $carnet) {
            return redirect()->route('register');
        }

        $request->validate([
            'selfie' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $tmpDir = "carnets-tmp/".$request->session()->getId();
        $pathSelfie = $request->file('selfie')->storeAs($tmpDir, 'selfie.jpg', 'local');
        $request->session()->put(self::SESSION_SELFIE, $pathSelfie);

        // Las conductoras deben cargar además la licencia de conducir.
        if (($datos['rol'] ?? null) === 'conductora') {
            return redirect()->route('registro.licencia');
        }

        return $this->finalizarRegistro($request);
    }

    public function mostrarLicencia(Request $request)
    {
        $datos = $request->session()->get(self::SESSION_DATOS);

        if (! $datos || ! $request->session()->has(self::SESSION_SELFIE)) {
            return redirect()->route('register');
        }
        if (($datos['rol'] ?? null) !== 'conductora') {
            return redirect()->route('registro.selfie');
        }

        return view('auth.registro-licencia');
    }

    public function guardarLicencia(Request $request): RedirectResponse
    {
        $datos = $request->session()->get(self::SESSION_DATOS);

        if (! $datos || ($datos['rol'] ?? null) !== 'conductora' ||
            ! $request->session()->has(self::SESSION_SELFIE)) {
            return redirect()->route('register');
        }

        $request->validate([
            'licencia' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $tmpDir = "carnets-tmp/".$request->session()->getId();
        $pathLicencia = $request->file('licencia')->storeAs($tmpDir, 'licencia.jpg', 'local');
        $request->session()->put(self::SESSION_LICENCIA, $pathLicencia);

        // Las conductoras declaran además el vehículo antes de finalizar.
        return redirect()->route('registro.vehiculo');
    }

    public function mostrarVehiculo(Request $request)
    {
        $datos = $request->session()->get(self::SESSION_DATOS);

        if (! $datos || ($datos['rol'] ?? null) !== 'conductora' ||
            ! $request->session()->has(self::SESSION_LICENCIA)) {
            return redirect()->route('register');
        }

        return view('auth.registro-vehiculo');
    }

    public function guardarVehiculo(Request $request): RedirectResponse
    {
        $datos = $request->session()->get(self::SESSION_DATOS);

        if (! $datos || ($datos['rol'] ?? null) !== 'conductora' ||
            ! $request->session()->has(self::SESSION_LICENCIA)) {
            return redirect()->route('register');
        }

        $vehiculo = $request->validate([
            'placa'             => ['required', 'string', 'max:20'],
            'marca_modelo'      => ['required', 'string', 'max:255'],
            'color'             => ['nullable', 'string', 'max:50'],
            'anio'              => ['nullable', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
            'relacion_declarada'=> ['required', 'in:propio,familiar,alquilado,otro'],
        ]);

        $request->session()->put(self::SESSION_VEHICULO, $vehiculo);

        return $this->finalizarRegistro($request);
    }

    private function finalizarRegistro(Request $request): RedirectResponse
    {
        $datos = $request->session()->get(self::SESSION_DATOS);
        $carnet = $request->session()->get(self::SESSION_CARNET);
        $selfieTmp = $request->session()->get(self::SESSION_SELFIE);
        $pathLicenciaTmp = $request->session()->get(self::SESSION_LICENCIA);
        $vehiculo = $request->session()->get(self::SESSION_VEHICULO);

        if (! $datos || ! $carnet || ! $selfieTmp) {
            return redirect()->route('register');
        }

        $rol = Role::where('nombre', $datos['rol'])->firstOrFail();

        $user = User::create([
            'name' => $datos['name'],
            'email' => $datos['email'],
            'password' => Hash::make($datos['password']),
            'telefono' => $datos['telefono'],
            'fecha_nacimiento' => $datos['fecha_nacimiento'],
            'numero_carnet' => $datos['numero_carnet'],
            'role_id' => $rol->id,
            'estado_verificacion' => 'analizando',
        ]);

        $dir = "carnets/{$user->id}";
        $cambios = [
            'carnet_anverso_path' => $this->moverArchivo($carnet['anverso'], "{$dir}/anverso.jpg"),
            'carnet_reverso_path' => $this->moverArchivo($carnet['reverso'], "{$dir}/reverso.jpg"),
            'selfie_path' => $this->moverArchivo($selfieTmp, "{$dir}/selfie.jpg"),
        ];

        if ($pathLicenciaTmp !== null) {
            $cambios['licencia_path'] = $this->moverArchivo($pathLicenciaTmp, "{$dir}/licencia.jpg");
        }

        $user->update($cambios);

        if ($vehiculo) {
            $user->vehiculo()->create($vehiculo);
        }

        event(new Registered($user));
        Auth::login($user);

        $request->session()->forget([
            self::SESSION_DATOS, self::SESSION_CARNET, self::SESSION_SELFIE,
            self::SESSION_LICENCIA, self::SESSION_VEHICULO,
        ]);

        // Crear registro normalizado (esquema tesis)
        $tipoRegistro = ($datos['rol'] === 'conductora') ? 'conductora' : 'pasajera';
        $reg = RegistroVerificacion::create([
            'user_id'         => $user->id,
            'tipo_registro'   => $tipoRegistro,
            'ruta_selfie'     => $cambios['selfie_path'],
            'estado_resultado' => 'analizando',
        ]);

        $docsMap = [
            'cedula_anverso' => $cambios['carnet_anverso_path'],
            'cedula_reverso' => $cambios['carnet_reverso_path'],
        ];
        if (isset($cambios['licencia_path'])) {
            $docsMap['licencia'] = $cambios['licencia_path'];
        }
        foreach ($docsMap as $tipo => $ruta) {
            $reg->documentos()->create([
                'tipo_documento' => $tipo,
                'ruta_imagen'    => $ruta,
            ]);
        }

        AnalizarRegistroJob::dispatch($user->id);

        return redirect()->route('dashboard');
    }

    public function estado()
    {
        $user = Auth::user();
        return response()->json([
            'estado' => $user->estado_verificacion,
            'motivo' => $user->resultado_analisis['motivo_rechazo'] ?? null,
        ]);
    }

    public function mostrarReenvio(Request $request)
    {
        $user = Auth::user();

        if ($user->estado_verificacion !== 'rechazada') {
            return redirect()->route('dashboard')
                ->with('error', 'Solo puedes reenviar documentos cuando tu registro fue rechazado.');
        }

        $esConductora = $user->esConductora();
        return view('registro.reenviar', compact('user', 'esConductora'));
    }

    public function guardarReenvio(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->estado_verificacion !== 'rechazada') {
            return redirect()->route('dashboard');
        }

        $esConductora = $user->esConductora();

        $reglas = [
            'anverso'          => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'reverso'          => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'selfie'           => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'fecha_nacimiento' => ['nullable', 'date', 'before:-18 years'],
            'numero_carnet'    => ['nullable', 'string', 'max:20', Rule::unique('users', 'numero_carnet')->ignore($user->id)],
        ];

        if ($esConductora) {
            $reglas['licencia'] = ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'];
        }

        $request->validate($reglas, [
            'fecha_nacimiento.before' => 'Debes ser mayor de 18 años para registrarte.',
            'numero_carnet.unique'    => 'Este número de carnet ya pertenece a otra usuaria registrada.',
        ]);

        $tieneDocumentoNuevo = $request->hasFile('anverso') || $request->hasFile('reverso')
            || $request->hasFile('selfie') || ($esConductora && $request->hasFile('licencia'));
        $tieneDatoCorregido  = $request->filled('fecha_nacimiento') || $request->filled('numero_carnet');

        if (! $tieneDocumentoNuevo && ! $tieneDatoCorregido) {
            return back()->withErrors(['anverso' => 'Debes cargar al menos un documento nuevo o corregir un dato declarado.']);
        }

        $dir    = "carnets/{$user->id}";
        $cambios = [];

        if ($request->hasFile('anverso')) {
            $cambios['carnet_anverso_path'] = $request->file('anverso')->storeAs($dir, 'anverso.jpg', 'local');
        }
        if ($request->hasFile('reverso')) {
            $cambios['carnet_reverso_path'] = $request->file('reverso')->storeAs($dir, 'reverso.jpg', 'local');
        }
        if ($request->hasFile('selfie')) {
            $cambios['selfie_path'] = $request->file('selfie')->storeAs($dir, 'selfie.jpg', 'local');
        }
        if ($esConductora && $request->hasFile('licencia')) {
            $cambios['licencia_path'] = $request->file('licencia')->storeAs($dir, 'licencia.jpg', 'local');
        }

        // Datos declarados corregibles
        if ($request->filled('fecha_nacimiento')) {
            $cambios['fecha_nacimiento'] = $request->input('fecha_nacimiento');
        }
        if ($request->filled('numero_carnet')) {
            $cambios['numero_carnet'] = $request->input('numero_carnet');
        }

        $cambios['estado_verificacion'] = 'analizando';
        $cambios['analizado_en'] = null;

        $resultado = $user->resultado_analisis ?? [];
        $historial = $resultado['historial_revisiones'] ?? [];
        $historial[] = [
            'accion' => 'reenvio_usuaria',
            'fecha'  => now()->toDateTimeString(),
        ];
        unset($resultado['motivo_rechazo']);
        $resultado['historial_revisiones'] = $historial;
        $cambios['resultado_analisis'] = $resultado;

        $user->update($cambios);

        // Nuevo registro normalizado para este reenvío
        $tipoRegistro = $user->esConductora() ? 'conductora' : 'pasajera';
        $reg = RegistroVerificacion::create([
            'user_id'          => $user->id,
            'tipo_registro'    => $tipoRegistro,
            'ruta_selfie'      => $cambios['selfie_path'] ?? $user->selfie_path,
            'estado_resultado' => 'analizando',
        ]);

        $docsMap = [
            'cedula_anverso' => $cambios['carnet_anverso_path'] ?? $user->carnet_anverso_path,
            'cedula_reverso' => $cambios['carnet_reverso_path'] ?? $user->carnet_reverso_path,
        ];
        if ($user->esConductora()) {
            $docsMap['licencia'] = $cambios['licencia_path'] ?? $user->licencia_path;
        }
        foreach ($docsMap as $tipo => $ruta) {
            if ($ruta) {
                $reg->documentos()->create([
                    'tipo_documento' => $tipo,
                    'ruta_imagen'    => $ruta,
                ]);
            }
        }

        BitacoraService::registrar('reenviar_documentos', 'User', $user->id, [
            'registro_id'       => $reg->id,
            'documentos_enviados' => array_keys($cambios),
        ], $user->id);

        AnalizarRegistroJob::dispatch($user->id);

        return redirect()->route('dashboard')
            ->with('status', 'Documentos enviados. Tu registro está siendo analizado nuevamente.');
    }

    private function moverArchivo(string $origen, string $destino): string
    {
        $disk = \Storage::disk('local');
        if ($disk->exists($origen)) {
            $disk->move($origen, $destino);
        }
        return $destino;
    }
}