@extends('layouts.admin')

@section('contenido')
<h1 class="text-2xl font-bold mb-6">Resumen</h1>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="stat bg-base-100 rounded-xl shadow">
        <div class="stat-title">Total usuarias</div>
        <div class="stat-value">{{ $stats['total'] }}</div>
    </div>
    <div class="stat bg-base-100 rounded-xl shadow">
        <div class="stat-title text-success">Verificadas</div>
        <div class="stat-value text-success">{{ $stats['verificadas'] }}</div>
        @if ($stats['total'] > 0)
            <div class="stat-desc">{{ round($stats['verificadas'] / $stats['total'] * 100) }}% del total</div>
        @endif
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

{{-- Gráficas --}}
<div class="grid lg:grid-cols-3 gap-6 mb-6">
    <div class="card bg-base-100 shadow lg:col-span-2">
        <div class="card-body">
            <h2 class="card-title text-base">Registros — últimos 7 días</h2>
            <div class="h-48">
                <canvas id="chartRegistros"></canvas>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h2 class="card-title text-base">Distribución por rol</h2>
            <div class="h-48 flex items-center justify-center">
                @if ($stats['total'] > 0)
                    <canvas id="chartRoles"></canvas>
                @else
                    <p class="text-base-content/40 text-sm">Sin datos aún.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card bg-base-100 shadow">
    <div class="card-body">
        <div class="flex items-center justify-between mb-2">
            <h2 class="card-title">Registros recientes</h2>
            <a href="{{ route('admin.usuarias') }}" class="link link-primary text-sm">Ver todas</a>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Registrada</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recientes as $u)
                        <tr>
                            <td class="font-medium">{{ $u->name }}</td>
                            <td><span class="badge badge-ghost badge-sm capitalize">{{ $u->role?->nombre }}</span></td>
                            <td>@include('admin.partials.badge-estado', ['estado' => $u->estado_verificacion])</td>
                            <td class="text-sm text-base-content/60">{{ $u->created_at->diffForHumans() }}</td>
                            <td><a href="{{ route('admin.usuaria.ver', $u) }}" class="btn btn-ghost btn-xs">Ver</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-base-content/60">Sin registros.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    // Gráfica de barras — registros por día
    new Chart(document.getElementById('chartRegistros').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Registros',
                data: @json($chartData),
                backgroundColor: 'rgba(220, 38, 38, 0.7)',
                borderColor: 'rgba(220, 38, 38, 1)',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, grid: { color: 'rgba(0,0,0,0.05)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Donut — distribución por rol
    @if ($stats['total'] > 0)
    new Chart(document.getElementById('chartRoles').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Pasajeras', 'Conductoras'],
            datasets: [{
                data: [{{ $stats['pasajeras'] }}, {{ $stats['conductoras'] }}],
                backgroundColor: ['rgba(59,130,246,0.8)', 'rgba(220,38,38,0.8)'],
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, padding: 12 } }
            },
            cutout: '65%',
        }
    });
    @endif
})();
</script>
@endsection
