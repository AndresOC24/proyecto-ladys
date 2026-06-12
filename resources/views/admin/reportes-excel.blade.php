<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">
<head><meta charset="utf-8"></head>
<body>
    @php
        $etiquetas = ['verificada' => 'Verificadas', 'rechazada' => 'Rechazadas', 'pendiente' => 'Pendientes', 'analizando' => 'Analizando'];
    @endphp

    <table border="1">
        <tr><td colspan="5"><b>Lady's On Go — Reporte</b></td></tr>
        <tr><td colspan="5">Periodo: {{ $desde->format('d/m/Y') }} a {{ $hasta->format('d/m/Y') }} · Generado: {{ $generadoEn->format('d/m/Y H:i') }}</td></tr>
    </table>
    <br>

    <table border="1">
        <tr><td colspan="5"><b>1. Reporte de verificaciones (histórico)</b></td></tr>
        <tr>@foreach ($etiquetas as $e => $l)<th>{{ $l }}</th>@endforeach<th>Total</th></tr>
        <tr>@foreach ($etiquetas as $e => $l)<td>{{ $verificaciones[$e] }}</td>@endforeach<td>{{ $totalGlobal }}</td></tr>
    </table>
    <br>

    <table border="1">
        <tr><td colspan="5"><b>2. Reporte por periodo</b></td></tr>
        <tr>@foreach ($etiquetas as $e => $l)<th>{{ $l }}</th>@endforeach<th>Total</th></tr>
        <tr>@foreach ($etiquetas as $e => $l)<td>{{ $periodoPorEstado[$e] }}</td>@endforeach<td>{{ $totalPeriodo }}</td></tr>
    </table>
    <br>

    <table border="1">
        <tr><th>Nombre</th><th>Email</th><th>Rol</th><th>Estado</th><th>Registrada</th></tr>
        @forelse ($usuariasPeriodo as $u)
            <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role?->nombre }}</td>
                <td>{{ $u->estado_verificacion }}</td>
                <td>{{ $u->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @empty
            <tr><td colspan="5">Sin registros en este periodo.</td></tr>
        @endforelse
    </table>
    <br>

    <table border="1">
        <tr><td colspan="4"><b>3. Reporte de tasa de rechazo</b></td></tr>
        <tr><th>Ámbito</th><th>Rechazadas</th><th>Decididas</th><th>Tasa de rechazo</th></tr>
        <tr><td>Global</td><td>{{ $tasaGlobal['rechazadas'] }}</td><td>{{ $tasaGlobal['decididas'] }}</td><td>{{ $tasaGlobal['tasa'] }}%</td></tr>
        <tr><td>Periodo</td><td>{{ $tasaPeriodo['rechazadas'] }}</td><td>{{ $tasaPeriodo['decididas'] }}</td><td>{{ $tasaPeriodo['tasa'] }}%</td></tr>
    </table>
</body>
</html>
