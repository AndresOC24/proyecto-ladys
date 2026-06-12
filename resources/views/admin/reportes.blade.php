@extends('layouts.admin')

@php
    $etiquetas = [
        'verificada' => 'Verificadas',
        'rechazada'  => 'Rechazadas',
        'pendiente'  => 'Pendientes',
        'analizando' => 'Analizando',
    ];
    $qs = ['desde' => $desde->format('Y-m-d'), 'hasta' => $hasta->format('Y-m-d')];
@endphp

@section('contenido')
<div class="flex items-center justify-between mb-6 flex-wrap gap-2">
    <h1 class="text-2xl font-bold">Reportes</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.reportes.exportar', ['formato' => 'pdf'] + $qs) }}" class="btn btn-error btn-sm">
            Exportar a PDF
        </a>
        <a href="{{ route('admin.reportes.exportar', ['formato' => 'excel'] + $qs) }}" class="btn btn-success btn-sm">
            Exportar a Excel
        </a>
    </div>
</div>

{{-- Filtro por periodo --}}
<div class="card bg-base-100 shadow mb-6">
    <div class="card-body">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
            <div>
                <label class="label"><span class="label-text text-xs">Desde</span></label>
                <input type="date" name="desde" value="{{ $desde->format('Y-m-d') }}" class="input input-bordered w-full">
            </div>
            <div>
                <label class="label"><span class="label-text text-xs">Hasta</span></label>
                <input type="date" name="hasta" value="{{ $hasta->format('Y-m-d') }}" class="input input-bordered w-full">
            </div>
            <div class="sm:col-span-2 flex gap-2">
                <button class="btn btn-primary">Aplicar periodo</button>
                <a href="{{ route('admin.reportes') }}" class="btn btn-ghost">Limpiar</a>
            </div>
        </form>
    </div>
</div>

{{-- 1. Reporte de verificaciones (global) --}}
<div class="card bg-base-100 shadow mb-6">
    <div class="card-body">
        <h2 class="card-title">Reporte de verificaciones</h2>
        <p class="text-sm text-base-content/60 mb-3">Estado de todas las usuarias registradas (histórico).</p>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach ($etiquetas as $estado => $label)
                <div class="stat bg-base-200 rounded-box">
                    <div class="stat-title text-xs">{{ $label }}</div>
                    <div class="stat-value text-2xl">{{ $verificaciones[$estado] }}</div>
                </div>
            @endforeach
        </div>
        <div class="text-sm mt-3">Total de usuarias: <strong>{{ $totalGlobal }}</strong></div>
    </div>
</div>

{{-- 2. Reporte por periodo --}}
<div class="card bg-base-100 shadow mb-6">
    <div class="card-body">
        <h2 class="card-title">Reporte por periodo</h2>
        <p class="text-sm text-base-content/60 mb-3">
            Registros entre <strong>{{ $desde->format('d/m/Y') }}</strong> y <strong>{{ $hasta->format('d/m/Y') }}</strong>.
        </p>

        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-4">
            @foreach ($etiquetas as $estado => $label)
                <div class="stat bg-base-200 rounded-box">
                    <div class="stat-title text-xs">{{ $label }}</div>
                    <div class="stat-value text-2xl">{{ $periodoPorEstado[$estado] }}</div>
                </div>
            @endforeach
            <div class="stat bg-primary text-primary-content rounded-box">
                <div class="stat-title text-xs text-primary-content/80">Total periodo</div>
                <div class="stat-value text-2xl">{{ $totalPeriodo }}</div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead>
                    <tr><th>Nombre</th><th>Email</th><th>Rol</th><th>Estado</th><th>Registrada</th></tr>
                </thead>
                <tbody>
                    @forelse ($usuariasPeriodo as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td class="text-sm">{{ $u->email }}</td>
                            <td>{{ $u->role?->nombre }}</td>
                            <td>@include('admin.partials.badge-estado', ['estado' => $u->estado_verificacion])</td>
                            <td class="text-sm text-base-content/60">{{ $u->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-base-content/60 py-6">Sin registros en este periodo.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 3. Reporte de tasa de rechazo --}}
<div class="card bg-base-100 shadow">
    <div class="card-body">
        <h2 class="card-title">Reporte de tasa de rechazo</h2>
        <p class="text-sm text-base-content/60 mb-3">Porcentaje de rechazos sobre los registros ya decididos (excluye «analizando»).</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="stat bg-base-200 rounded-box">
                <div class="stat-title">Global</div>
                <div class="stat-value text-error">{{ $tasaGlobal['tasa'] }}%</div>
                <div class="stat-desc">{{ $tasaGlobal['rechazadas'] }} de {{ $tasaGlobal['decididas'] }} decididas</div>
            </div>
            <div class="stat bg-base-200 rounded-box">
                <div class="stat-title">En el periodo</div>
                <div class="stat-value text-error">{{ $tasaPeriodo['tasa'] }}%</div>
                <div class="stat-desc">{{ $tasaPeriodo['rechazadas'] }} de {{ $tasaPeriodo['decididas'] }} decididas</div>
            </div>
        </div>
    </div>
</div>
@endsection
