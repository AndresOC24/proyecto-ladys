<x-guest-layout>
    <x-auth-split titulo="Nueva contraseña" subtitulo="Crea una contraseña segura para tu cuenta">
        @if ($errors->any())
            <div role="alert" class="alert alert-error mb-4">
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            {{-- Token de reseteo --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <label class="floating-label">
                <span>Correo electrónico</span>
                <input type="email" name="email" value="{{ old('email', $request->email) }}"
                       placeholder="Correo electrónico"
                       class="input input-bordered w-full" required autofocus autocomplete="username">
            </label>

            <label class="floating-label">
                <span>Nueva contraseña</span>
                <input type="password" name="password" placeholder="Nueva contraseña"
                       class="input input-bordered w-full" required autocomplete="new-password">
            </label>

            <label class="floating-label">
                <span>Confirmar contraseña</span>
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña"
                       class="input input-bordered w-full" required autocomplete="new-password">
            </label>

            <button type="submit" class="btn btn-primary w-full">Restablecer contraseña</button>

            <p class="text-center text-sm">
                <a href="{{ route('login') }}" class="link link-primary">← Volver a iniciar sesión</a>
            </p>
        </form>
    </x-auth-split>
</x-guest-layout>
