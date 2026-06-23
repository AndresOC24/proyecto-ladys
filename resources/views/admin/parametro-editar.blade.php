@extends('layouts.admin')

@section('contenido')
<div class="text-sm breadcrumbs mb-4">
    <ul>
        <li><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li><a href="{{ route('admin.parametros') }}">Parámetros</a></li>
        <li>Editar</li>
    </ul>
</div>
<div class="max-w-lg">

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h1 class="card-title text-xl mb-4">Editar parámetro</h1>

            @if ($errors->any())
                <div role="alert" class="alert alert-error mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.parametros.actualizar', $parametro) }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium">Tipo de documento</span></label>
                    <select name="tipo_documento" class="select select-bordered @error('tipo_documento') select-error @enderror">
                        <option value="cedula" @selected(old('tipo_documento', $parametro->tipo_documento) === 'cedula')>Cédula de identidad</option>
                        <option value="licencia" @selected(old('tipo_documento', $parametro->tipo_documento) === 'licencia')>Licencia de conducir</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium">Nombre del parámetro</span></label>
                    <input type="text" name="nombre_parametro"
                           value="{{ old('nombre_parametro', $parametro->nombre_parametro) }}" required
                           class="input input-bordered @error('nombre_parametro') input-error @enderror"
                           placeholder="Ej. numero_cedula, vigencia_cedula">
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium">Categoría</span></label>
                    <select name="categoria" class="select select-bordered @error('categoria') select-error @enderror">
                        @foreach (['campo_requerido', 'vigencia', 'formato', 'coherencia'] as $cat)
                            <option value="{{ $cat }}" @selected(old('categoria', $parametro->categoria) === $cat)>
                                {{ ucfirst(str_replace('_', ' ', $cat)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="hidden" name="es_bloqueante" value="0">
                        <input type="checkbox" name="es_bloqueante" value="1"
                               class="checkbox checkbox-error"
                               @checked(old('es_bloqueante', $parametro->es_bloqueante))>
                        <span class="label-text font-medium">Es bloqueante (impide aprobación automática si falla)</span>
                    </label>
                </div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('admin.parametros') }}" class="btn btn-ghost flex-1">Cancelar</a>
                    <button type="submit" class="btn btn-primary flex-1">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
