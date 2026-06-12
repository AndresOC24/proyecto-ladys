<x-guest-layout>
    <x-auth-split titulo="Recuperar contraseña" subtitulo="Te ayudamos a recuperar el acceso a tu cuenta">
        @if (session('status'))
            <div role="alert" class="alert alert-success mb-4">
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if (session('reset_link'))
            <div role="alert" class="alert alert-info mb-4 flex-col items-start gap-2">
                <span class="text-sm font-semibold">Enlace para restablecer tu contraseña (modo desarrollo):</span>
                <a href="{{ session('reset_link') }}" class="link link-primary break-all text-sm">
                    {{ session('reset_link') }}
                </a>
            </div>
        @endif

        @if ($errors->any())
            <div role="alert" class="alert alert-error mb-4">
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <p class="text-sm text-base-content/60 mb-4">
            Ingresa el correo con el que te registraste y te daremos un enlace para crear una nueva contraseña.
        </p>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <label class="floating-label">
                <span>Correo electrónico</span>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="Correo electrónico"
                       class="input input-bordered w-full" required autofocus>
            </label>

            <button type="submit" class="btn btn-primary w-full">Enviar enlace de recuperación</button>

            <p class="text-center text-sm">
                <a href="{{ route('login') }}" class="link link-primary">← Volver a iniciar sesión</a>
            </p>
        </form>
    </x-auth-split>
</x-guest-layout>
