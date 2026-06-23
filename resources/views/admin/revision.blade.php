@extends('layouts.admin')

@section('contenido')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">Bandeja de revisión</h1>
        <p class="text-sm text-base-content/60 mt-1">
            Casos derivados a revisión manual por el sistema de IA.
            @if ($total > 0)
                <span class="badge badge-warning badge-sm ml-1">{{ $total }} pendiente{{ $total !== 1 ? 's' : '' }}</span>
            @else
                <span class="badge badge-success badge-sm ml-1">Sin casos pendientes</span>
            @endif
        </p>
    </div>
</div>

{{-- Filtro de rol --}}
<div class="card bg-base-100 shadow mb-4">
    <div class="card-body py-3">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="label py-0 pb-1"><span class="label-text text-xs">Rol</span></label>
                <select name="rol" class="select select-bordered select-sm">
                    <option value="">Todos</option>
                    <option value="pasajero" @selected(request('rol') === 'pasajero')>Pasajera</option>
                    <option value="conductora" @selected(request('rol') === 'conductora')>Conductora</option>
                </select>
            </div>
            <button class="btn btn-primary btn-sm">Filtrar</button>
            <a href="{{ route('admin.revision') }}" class="btn btn-ghost btn-sm">Limpiar</a>
        </form>
    </div>
</div>

@if ($pendientes->isEmpty())
    <div class="card bg-base-100 shadow">
        <div class="card-body text-center py-16">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-success mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-semibold">Sin casos pendientes</h3>
            <p class="text-base-content/60 text-sm mt-1">No hay registros que requieran revisión manual en este momento.</p>
        </div>
    </div>
@else
    <div class="space-y-3">
        @foreach ($pendientes as $u)
            <div class="card bg-base-100 shadow hover:shadow-md transition-shadow">
                <div class="card-body py-4">
                    <div class="flex items-center gap-4">
                        {{-- Avatar --}}
                        <div class="avatar placeholder shrink-0">
                            <div class="bg-warning/20 text-warning rounded-full w-10 h-10">
                                <span class="text-sm font-bold">{{ strtoupper(substr($u->name, 0, 1)) }}</span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-semibold">{{ $u->name }}</span>
                                <span class="badge badge-ghost badge-sm">{{ $u->role?->nombre }}</span>
                                <span class="badge badge-warning badge-sm">Pendiente de revisión</span>
                            </div>
                            <div class="text-sm text-base-content/60 mt-0.5">
                                {{ $u->email }} · Carnet: <span class="font-mono">{{ $u->numero_carnet }}</span>
                            </div>
                            @if (! empty($u->resultado_analisis['motivo_rechazo']))
                                <div class="text-xs text-warning mt-1 italic">
                                    "{{ $u->resultado_analisis['motivo_rechazo'] }}"
                                </div>
                            @endif
                        </div>

                        {{-- Meta + CTA --}}
                        <div class="text-right shrink-0">
                            <div class="text-xs text-base-content/50 mb-2">
                                Registrada {{ $u->created_at->diffForHumans() }}
                            </div>
                            <a href="{{ route('admin.usuaria.ver', $u) }}" class="btn btn-warning btn-sm">
                                Revisar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $pendientes->links() }}</div>
@endif
@endsection
