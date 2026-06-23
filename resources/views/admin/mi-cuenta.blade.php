@extends('layouts.admin')

@section('contenido')
<div class="max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Mi cuenta</h1>

    @if (session('status') === 'password-updated')
        <div role="alert" class="alert alert-success mb-4">
            <span>Contraseña actualizada correctamente.</span>
        </div>
    @endif

    {{-- Datos del perfil admin --}}
    <div class="card bg-base-100 shadow mb-6">
        <div class="card-body">
            <h2 class="card-title">Datos de la cuenta</h2>
            <dl class="grid grid-cols-1 gap-y-2 text-sm mt-2">
                <div><dt class="text-base-content/60">Nombre</dt><dd class="font-medium">{{ auth()->user()->name }}</dd></div>
                <div><dt class="text-base-content/60">Correo</dt><dd>{{ auth()->user()->email }}</dd></div>
                <div><dt class="text-base-content/60">Rol</dt><dd class="capitalize">{{ auth()->user()->role?->nombre }}</dd></div>
            </dl>
        </div>
    </div>

    {{-- Cambiar contraseña --}}
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h2 class="card-title">Cambiar contraseña</h2>
            <p class="text-sm text-base-content/60 mb-4">Usa una contraseña larga y única para proteger tu cuenta de administración.</p>

            @if ($errors->updatePassword->any())
                <div role="alert" class="alert alert-error mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->updatePassword->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium">Contraseña actual</span></label>
                    <input type="password" name="current_password" autocomplete="current-password"
                           class="input input-bordered @error('current_password', 'updatePassword') input-error @enderror">
                </div>

                <div class="form-control" x-data="{
                    pwd: '',
                    get fuerza() {
                        if (!this.pwd) return 0;
                        let s = 0;
                        if (this.pwd.length >= 8)  s++;
                        if (this.pwd.length >= 12) s++;
                        if (/[A-Z]/.test(this.pwd)) s++;
                        if (/[0-9]/.test(this.pwd)) s++;
                        if (/[^A-Za-z0-9]/.test(this.pwd)) s++;
                        return Math.min(s, 4);
                    },
                    get color() { return ['','bg-error','bg-warning','bg-info','bg-success'][this.fuerza]; },
                    get label() { return ['','Débil','Regular','Buena','Fuerte'][this.fuerza]; }
                }">
                    <label class="label"><span class="label-text font-medium">Nueva contraseña</span></label>
                    <input type="password" name="password" autocomplete="new-password" x-model="pwd"
                           class="input input-bordered @error('password', 'updatePassword') input-error @enderror">
                    <div class="mt-2 space-y-1" x-show="pwd.length > 0">
                        <div class="flex gap-1">
                            <template x-for="i in 4">
                                <div class="h-1.5 flex-1 rounded-full transition-colors"
                                     :class="i <= fuerza ? color : 'bg-base-300'"></div>
                            </template>
                        </div>
                        <span class="text-xs" :class="{'text-error':fuerza===1,'text-warning':fuerza===2,'text-info':fuerza===3,'text-success':fuerza===4}" x-text="label"></span>
                    </div>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium">Confirmar nueva contraseña</span></label>
                    <input type="password" name="password_confirmation" autocomplete="new-password"
                           class="input input-bordered">
                </div>

                <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
            </form>
        </div>
    </div>
</div>
@endsection
