@extends('layouts.admin')

@section('contenido')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">Parámetros de control</h1>
        <p class="text-sm text-base-content/60 mt-1">
            Define qué reglas de validación son bloqueantes (impiden la aprobación automática).
        </p>
    </div>
    <a href="{{ route('admin.parametros.crear') }}" class="btn btn-primary btn-sm">+ Nuevo parámetro</a>
</div>

@php $porTipo = $parametros->groupBy('tipo_documento'); @endphp

@foreach ($porTipo as $tipo => $params)
    <div class="card bg-base-100 shadow mb-6">
        <div class="card-body">
            <h2 class="card-title capitalize">{{ str_replace('_', ' ', $tipo) }}</h2>
            <div class="overflow-x-auto">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Parámetro</th>
                            <th>Categoría</th>
                            <th class="text-center">¿Bloqueante?</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($params as $p)
                            <tr class="hover">
                                <td class="font-medium">{{ $p->nombre_parametro }}</td>
                                <td>
                                    <span class="badge badge-ghost badge-sm">{{ str_replace('_', ' ', $p->categoria) }}</span>
                                </td>
                                <td class="text-center">
                                    @if ($p->es_bloqueante)
                                        <span class="badge badge-error badge-sm">Sí</span>
                                    @else
                                        <span class="badge badge-ghost badge-sm">No</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center justify-end gap-2">
                                        <form method="POST" action="{{ route('admin.parametros.toggle', $p) }}">
                                            @csrf
                                            <button class="btn btn-xs {{ $p->es_bloqueante ? 'btn-outline btn-warning' : 'btn-outline btn-success' }}">
                                                {{ $p->es_bloqueante ? 'Desbloquear' : 'Bloquear' }}
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.parametros.editar', $p) }}" class="btn btn-xs btn-ghost">Editar</a>
                                        <form method="POST" action="{{ route('admin.parametros.eliminar', $p) }}"
                                              onsubmit="return confirm('¿Eliminar el parámetro «{{ $p->nombre_parametro }}»?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-xs btn-ghost text-error">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endforeach

@if ($parametros->isEmpty())
    <div class="card bg-base-100 shadow">
        <div class="card-body text-center text-base-content/50">
            No hay parámetros configurados. Ejecuta <code>php artisan db:seed --class=ParametrosControlSeeder</code>.
        </div>
    </div>
@endif
@endsection
