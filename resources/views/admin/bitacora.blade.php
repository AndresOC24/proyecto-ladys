@extends('layouts.admin')

@section('contenido')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Bitácora de auditoría</h1>
    <span class="badge badge-outline">{{ $registros->total() }} eventos</span>
</div>

{{-- Filtros --}}
<form method="GET" class="flex flex-wrap gap-3 mb-6 items-end">
    <div>
        <label class="label py-0 pb-1"><span class="label-text text-xs">Acción</span></label>
        <select name="accion" class="select select-bordered select-sm">
            <option value="">Todas las acciones</option>
            @foreach ($acciones as $a)
                <option value="{{ $a }}" @selected(request('accion') === $a)>{{ $a }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label py-0 pb-1"><span class="label-text text-xs">Usuaria</span></label>
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Buscar por nombre o email…" class="input input-bordered input-sm w-48">
    </div>
    <div>
        <label class="label py-0 pb-1"><span class="label-text text-xs">Desde</span></label>
        <input type="date" name="desde" value="{{ request('desde') }}" class="input input-bordered input-sm">
    </div>
    <div>
        <label class="label py-0 pb-1"><span class="label-text text-xs">Hasta</span></label>
        <input type="date" name="hasta" value="{{ request('hasta') }}" class="input input-bordered input-sm">
    </div>
    <button class="btn btn-sm btn-neutral">Filtrar</button>
    @if (request()->hasAny(['accion', 'q', 'desde', 'hasta']))
        <a href="{{ route('admin.bitacora') }}" class="btn btn-sm btn-ghost">Limpiar</a>
    @endif
</form>

<div class="card bg-base-100 shadow overflow-x-auto">
    <table class="table table-sm">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Acción</th>
                <th>Usuaria (actor)</th>
                <th>Modelo / ID</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($registros as $reg)
                <tr class="hover">
                    <td class="whitespace-nowrap text-xs text-base-content/60">
                        {{ $reg->created_at->format('d/m/Y H:i:s') }}
                    </td>
                    <td>
                        @php
                            $color = match(true) {
                                str_contains($reg->accion, 'aprobar') => 'badge-success',
                                str_contains($reg->accion, 'rechazar') => 'badge-error',
                                str_contains($reg->accion, 'eliminar') => 'badge-error',
                                str_contains($reg->accion, 'desactivar') => 'badge-warning',
                                $reg->accion === 'login' => 'badge-info',
                                default => 'badge-ghost',
                            };
                        @endphp
                        <span class="badge badge-sm {{ $color }}">{{ $reg->accion }}</span>
                    </td>
                    <td class="text-sm">
                        @if ($reg->usuario)
                            <div class="font-medium">{{ $reg->usuario->name }}</div>
                            <div class="text-xs text-base-content/60">{{ $reg->usuario->email }}</div>
                        @else
                            <span class="text-base-content/40 text-xs">Sistema</span>
                        @endif
                    </td>
                    <td class="text-xs font-mono text-base-content/60">
                        {{ $reg->modelo ? "{$reg->modelo} #{$reg->modelo_id}" : '—' }}
                    </td>
                    <td class="text-xs max-w-xs truncate">
                        @if ($reg->detalles)
                            <details>
                                <summary class="cursor-pointer text-base-content/60">Ver</summary>
                                <pre class="text-xs bg-base-200 p-2 rounded mt-1 overflow-x-auto">{{ json_encode($reg->detalles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </details>
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-base-content/50 py-8">Sin eventos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $registros->withQueryString()->links() }}
</div>
@endsection
