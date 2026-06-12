@extends('layouts.admin')

@section('contenido')
<h1 class="text-2xl font-bold mb-6">Resumen</h1>

<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="stat bg-base-100 rounded-xl shadow">
        <div class="stat-title">Total usuarias</div>
        <div class="stat-value">{{ $stats['total'] }}</div>
    </div>
    <div class="stat bg-base-100 rounded-xl shadow">
        <div class="stat-title text-success">Verificadas</div>
        <div class="stat-value text-success">{{ $stats['verificadas'] }}</div>
    </div>
    <div class="stat bg-base-100 rounded-xl shadow">
        <div class="stat-title text-info">Analizando</div>
        <div class="stat-value text-info">{{ $stats['analizando'] }}</div>
    </div>
    <div class="stat bg-base-100 rounded-xl shadow">
        <div class="stat-title text-warning">Pendientes</div>
        <div class="stat-value text-warning">{{ $stats['pendientes'] }}</div>
    </div>
    <div class="stat bg-base-100 rounded-xl shadow">
        <div class="stat-title text-error">Rechazadas</div>
        <div class="stat-value text-error">{{ $stats['rechazadas'] }}</div>
    </div>
</div>

<div class="card bg-base-100 shadow">
    <div class="card-body">
        <div class="flex items-center justify-between mb-2">
            <h2 class="card-title">Registros recientes</h2>
            <a href="{{ route('admin.usuarias') }}" class="link link-primary text-sm">Ver todas</a>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recientes as $u)
                        <tr>
                            <td class="font-medium">{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td><span class="badge badge-ghost">{{ $u->role?->nombre }}</span></td>
                            <td>@include('admin.partials.badge-estado', ['estado' => $u->estado_verificacion])</td>
                            <td class="text-sm text-base-content/60">{{ $u->created_at->diffForHumans() }}</td>
                            <td><a href="{{ route('admin.usuaria.ver', $u) }}" class="btn btn-ghost btn-sm">Ver</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-base-content/60">Aún no hay registros.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection