<?php

namespace App\Http\Controllers;

use App\Jobs\AnalizarRegistroJob;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegistroController extends Controller
{
    private const SESSION_DATOS = 'registro.datos';
    private const SESSION_CARNET = 'registro.carnet';

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
            'numero_carnet' => ['required', 'string', 'max:20'],
            'rol' => ['required', 'in:pasajero,conductora'],
        ], [
            'fecha_nacimiento.before' => 'Debes ser mayor de 18 años para registrarte.',
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

    public function finalizar(Request $request): RedirectResponse
    {
        $datos = $request->session()->get(self::SESSION_DATOS);
        $carnet = $request->session()->get(self::SESSION_CARNET);

        if (! $datos || ! $carnet) {
            return redirect()->route('register');
        }

        $request->validate([
            'selfie' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

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
        $pathAnverso = $this->moverArchivo($carnet['anverso'], "{$dir}/anverso.jpg");
        $pathReverso = $this->moverArchivo($carnet['reverso'], "{$dir}/reverso.jpg");
        $pathSelfie = $request->file('selfie')->storeAs($dir, 'selfie.jpg', 'local');

        $user->update([
            'carnet_anverso_path' => $pathAnverso,
            'carnet_reverso_path' => $pathReverso,
            'selfie_path' => $pathSelfie,
        ]);

        event(new Registered($user));
        Auth::login($user);

        $request->session()->forget([self::SESSION_DATOS, self::SESSION_CARNET]);

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

    private function moverArchivo(string $origen, string $destino): string
    {
        $disk = \Storage::disk('local');
        if ($disk->exists($origen)) {
            $disk->move($origen, $destino);
        }
        return $destino;
    }
}