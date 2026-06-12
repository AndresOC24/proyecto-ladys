@extends('layouts.admin')

@section('contenido')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Usuarias</h1>
</div>

<div class="card bg-base-100 shadow mb-4">
    <div class="card-body">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar nombre, email o carnet"
                   class="input input-bordered sm:col-span-2">

            <select name="estado" class="select select-bordered">
                <option value="">Todos los estados</option>
                @foreach (['analizando','verificada','pendiente','rechazada'] as $e)
                    <option value="{{ $e }}" @selected(request('estado')===$e)>{{ ucfirst($e) }}</option>
                @endforeach
            </select>

            <select name="rol" class="select select-bordered">
                <option value="">Todos los roles</option>
                <option value="pasajero" @selected(request('rol')==='pasajero')>Pasajera</option>
                <option value="conductora" @selected(request('rol')==='conductora')>Conductora</option>
            </select>

            <div class="sm:col-span-4 flex gap-2">
                <button class="btn btn-primary">Filtrar</button>
                <a href="{{ route('admin.usuarias') }}" class="btn btn-ghost">Limpiar</a>
            </div>
        </form>
    </div>
</div>

<div class="card bg-base-100 shadow">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Carnet</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Registrada</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarias as $u)
                        <tr>
                            <td class="font-medium">{{ $u->name }}</td>
                            <td class="text-sm">{{ $u->email }}</td>
                            <td class="font-mono text-sm">{{ $u->numero_carnet }}</td>
                            <td><span class="badge badge-ghost">{{ $u->role?->nombre }}</span></td>
                            <td>@include('admin.partials.badge-estado', ['estado' => $u->estado_verificacion])</td>
                            <td class="text-sm text-base-content/60">{{ $u->created_at->format('d/m/Y H:i') }}</td>
                            <td><a href="{{ route('admin.usuaria.ver', $u) }}" class="btn btn-primary btn-sm">Ver</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-base-content/60 py-8">No hay resultados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">{{ $usuarias->links() }}</div>
    </div>
</div>
@endsection