@extends('layouts.admin')

@section('contenido')
<div class="text-sm breadcrumbs mb-4">
    <ul>
        <li><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li><a href="{{ route('admin.administradoras') }}">Administradoras</a></li>
        <li>Nueva administradora</li>
    </ul>
</div>
<div class="max-w-lg">

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h1 class="card-title text-xl mb-4">Nueva administradora</h1>

            @if ($errors->any())
                <div role="alert" class="alert alert-error mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.administradoras.guardar') }}" class="space-y-4">
                @csrf

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium">Nombre completo</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="input input-bordered @error('name') input-error @enderror"
                           placeholder="Ej. María López">
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium">Correo electrónico</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="input input-bordered @error('email') input-error @enderror"
                           placeholder="admin@ladysonigo.bo">
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium">Contraseña</span></label>
                    <input type="password" name="password" required
                           class="input input-bordered @error('password') input-error @enderror"
                           placeholder="Mínimo 8 caracteres">
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium">Confirmar contraseña</span></label>
                    <input type="password" name="password_confirmation" required
                           class="input input-bordered"
                           placeholder="Repite la contraseña">
                </div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('admin.administradoras') }}" class="btn btn-ghost flex-1">Cancelar</a>
                    <button type="submit" class="btn btn-primary flex-1">Crear cuenta</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
