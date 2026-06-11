<x-guest-layout>
    <x-auth-split titulo="Bienvenida de vuelta" subtitulo="Inicia sesión para continuar">
        @if (session('status'))
            <div role="alert" class="alert alert-success mb-4">
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div role="alert" class="alert alert-error mb-4">
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <label class="floating-label">
                <span>Correo electrónico</span>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="Correo electrónico"
                       class="input input-bordered w-full" required autofocus>
            </label>

            <label class="floating-label">
                <span>Contraseña</span>
                <input type="password" name="password" placeholder="Contraseña"
                       class="input input-bordered w-full" required>
            </label>

            <div class="flex items-center justify-between">
                <label class="label cursor-pointer gap-2 p-0">
                    <input type="checkbox" name="remember" class="checkbox checkbox-sm checkbox-primary">
                    <span class="label-text">Recordarme</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link link-primary text-sm">¿Olvidaste tu contraseña?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary w-full">Iniciar sesión</button>

            <div class="divider text-xs text-base-content/50">o</div>

            <p class="text-center text-sm">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="link link-primary font-semibold">Regístrate</a>
            </p>
        </form>
    </x-auth-split>
</x-guest-layout>