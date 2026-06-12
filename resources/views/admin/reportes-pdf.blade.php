<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        body { font-size: 11px; color: #222; }
        h1 { font-size: 18px; margin: 0 0 2px; }
        h2 { font-size: 13px; margin: 18px 0 6px; border-bottom: 1px solid #ccc; padding-bottom: 3px; }
        .sub { color: #666; font-size: 10px; margin: 0 0 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        th, td { border: 1px solid #ccc; padding: 5px 7px; text-align: left; }
        th { background: #f0f0f0; }
        .stat-grid td { text-align: center; }
        .num { font-size: 16px; font-weight: bold; }
        .rechazo { font-size: 20px; font-weight: bold; color: #c0152f; }
    </style>
</head>
<body>
    @php
        $etiquetas = ['verificada' => 'Verificadas', 'rechazada' => 'Rechazadas', 'pendiente' => 'Pendientes', 'analizando' => 'Analizando'];
    @endphp

    <h1>Lady's On Go — Reporte</h1>
    <p class="sub">
        Periodo: {{ $desde->format('d/m/Y') }} a {{ $hasta->format('d/m/Y') }} ·
        Generado: {{ $generadoEn->format('d/m/Y H:i') }}
    </p>

    <h2>1. Reporte de verificaciones (histórico)</h2>
    <table class="stat-grid">
        <tr>@foreach ($etiquetas as $e => $l)<th>{{ $l }}</th>@endforeach<th>Total</th></tr>
        <tr>
            @foreach ($etiquetas as $e => $l)<td class="num">{{ $verificaciones[$e] }}</td>@endforeach
            <td class="num">{{ $totalGlobal }}</td>
        </tr>
    </table>

    <h2>2. Reporte por periodo</h2>
    <table class="stat-grid">
        <tr>@foreach ($etiquetas as $e => $l)<th>{{ $l }}</th>@endforeach<th>Total</th></tr>
        <tr>
            @foreach ($etiquetas as $e => $l)<td class="num">{{ $periodoPorEstado[$e] }}</td>@endforeach
            <td class="num">{{ $totalPeriodo }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr><th>Nombre</th><th>Email</th><th>Rol</th><th>Estado</th><th>Registrada</th></tr>
        </thead>
        <tbody>
            @forelse ($usuariasPeriodo as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->role?->nombre }}</td>
                    <td>{{ $u->estado_verificacion }}</td>
                    <td>{{ $u->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;color:#888;">Sin registros en este periodo.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>3. Reporte de tasa de rechazo</h2>
    <table>
        <tr><th>Ámbito</th><th>Rechazadas</th><th>Decididas</th><th>Tasa de rechazo</th></tr>
        <tr>
            <td>Global</td>
            <td>{{ $tasaGlobal['rechazadas'] }}</td>
            <td>{{ $tasaGlobal['decididas'] }}</td>
            <td class="rechazo">{{ $tasaGlobal['tasa'] }}%</td>
        </tr>
        <tr>
            <td>Periodo</td>
            <td>{{ $tasaPeriodo['rechazadas'] }}</td>
            <td>{{ $tasaPeriodo['decididas'] }}</td>
            <td class="rechazo">{{ $tasaPeriodo['tasa'] }}%</td>
        </tr>
    </table>
</body>
</html>
