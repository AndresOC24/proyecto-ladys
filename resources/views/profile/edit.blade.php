<x-app-layout>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status') === 'profile-updated')
                <div role="alert" class="alert alert-success">
                    <span>Tu perfil fue actualizado correctamente.</span>
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div role="alert" class="alert alert-success">
                    <span>Tu contraseña fue cambiada correctamente.</span>
                </div>
            @endif

            {{-- Datos del perfil --}}
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Mis datos</h2>
                    <p class="text-sm text-base-content/60 mb-4">Actualiza tu nombre y teléfono de contacto.</p>

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                        @csrf
                        @method('patch')

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Nombre completo</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="input input-bordered @error('name') input-error @enderror">
                            @error('name') <div class="label"><span class="label-text-alt text-error">{{ $message }}</span></div> @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Correo electrónico</span></label>
                            <input type="email" value="{{ $user->email }}" disabled class="input input-bordered input-disabled">
                            <div class="label"><span class="label-text-alt text-base-content/50">El correo no puede modificarse.</span></div>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Teléfono</span></label>
                            <input type="text" name="telefono" value="{{ old('telefono', $user->telefono) }}"
                                   class="input input-bordered @error('telefono') input-error @enderror"
                                   placeholder="Ej. +591 70000000">
                            @error('telefono') <div class="label"><span class="label-text-alt text-error">{{ $message }}</span></div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>

            {{-- Cambiar contraseña --}}
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Cambiar contraseña</h2>
                    <p class="text-sm text-base-content/60 mb-4">Usa una contraseña larga y aleatoria para mayor seguridad.</p>

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        @method('put')

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Contraseña actual</span></label>
                            <input type="password" name="current_password" autocomplete="current-password"
                                   class="input input-bordered @error('current_password', 'updatePassword') input-error @enderror">
                            @error('current_password', 'updatePassword')
                                <div class="label"><span class="label-text-alt text-error">{{ $message }}</span></div>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Nueva contraseña</span></label>
                            <input type="password" name="password" autocomplete="new-password"
                                   class="input input-bordered @error('password', 'updatePassword') input-error @enderror">
                            @error('password', 'updatePassword')
                                <div class="label"><span class="label-text-alt text-error">{{ $message }}</span></div>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Confirmar nueva contraseña</span></label>
                            <input type="password" name="password_confirmation" autocomplete="new-password"
                                   class="input input-bordered">
                        </div>

                        <button type="submit" class="btn btn-neutral">Cambiar contraseña</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
