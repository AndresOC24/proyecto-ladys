<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        // Mensaje neutro: no revelamos si el correo está o no registrado.
        if (! $user) {
            return back()->with('status', 'Si el correo está registrado, generaremos un enlace de recuperación.');
        }

        // Generamos el token estándar de Laravel (queda guardado en password_reset_tokens)
        // y construimos el enlace oficial de reseteo.
        $token = Password::broker()->createToken($user);

        $enlace = route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]);

        // Modo desarrollo (MAIL_MAILER=log): en lugar de depender de la entrega por
        // correo, mostramos el enlace directamente en pantalla. Cuando se configure
        // un SMTP real basta con volver a usar Password::sendResetLink().
        return back()
            ->with('status', 'Enlace de recuperación generado.')
            ->with('reset_link', $enlace);
    }
}
