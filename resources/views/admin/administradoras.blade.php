@extends('layouts.admin')

@section('contenido')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">Administradoras</h1>
        <p class="text-sm text-base-content/60 mt-1">Cuentas con rol de administrador del sistema.</p>
    </div>
    <a href="{{ route('admin.administradoras.crear') }}" class="btn btn-primary btn-sm">+ Nueva administradora</a>
</div>

<div class="card bg-base-100 shadow overflow-x-auto">
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Registrada</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($admins as $admin)
                <tr class="hover">
                    <td class="font-medium">{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        @if ($admin->activa)
                            <span class="badge badge-success badge-sm">Activa</span>
                        @else
                            <span class="badge badge-error badge-sm">Desactivada</span>
                        @endif
                    </td>
                    <td class="text-sm text-base-content/60">{{ $admin->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if ($admin->id !== auth()->id())
                            <div class="flex gap-2">
                                @if ($admin->activa)
                                    <form method="POST" action="{{ route('admin.usuaria.desactivar', $admin) }}">
                                        @csrf
                                        <button class="btn btn-xs btn-warning">Desactivar</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.usuaria.reactivar', $admin) }}">
                                        @csrf
                                        <button class="btn btn-xs btn-success">Reactivar</button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <span class="text-xs text-base-content/40">(tú)</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-base-content/50 py-8">No hay administradoras registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
