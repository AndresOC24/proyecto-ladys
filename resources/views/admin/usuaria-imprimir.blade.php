<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ficha — {{ $u->name }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-white p-8 max-w-2xl mx-auto text-sm font-sans">

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-gray-200">
        <div>
            <div class="text-xs text-gray-400 uppercase tracking-widest mb-1">Lady's On Go — Ficha de verificación</div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $u->name }}</h1>
            <p class="text-gray-500">{{ $u->email }}</p>
        </div>
        <div class="text-right">
            @php
                $color = match($u->estado_verificacion) {
                    'verificada' => '#16a34a',
                    'rechazada'  => '#dc2626',
                    'pendiente'  => '#d97706',
                    'analizando' => '#2563eb',
                    default      => '#6b7280',
                };
            @endphp
            <span style="color: {{ $color }}; border: 1.5px solid {{ $color }}; padding: 4px 12px; border-radius: 999px; font-weight: 600; text-transform: capitalize;">
                {{ $u->estado_verificacion }}
            </span>
            <div class="text-xs text-gray-400 mt-1">{{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    {{-- Alerta duplicado --}}
    @php $dup = $u->resultado_analisis['posible_duplicado'] ?? null; @endphp
    @if ($dup)
    <div style="background:#fee2e2;border:1.5px solid #dc2626;border-radius:6px;padding:10px 14px;margin-bottom:16px;">
        <strong style="color:#dc2626;">⚠ Posible cuenta duplicada:</strong>
        el carnet OCR (<strong>{{ $u->resultado_analisis['numero_extraido'] ?? '—' }}</strong>)
        coincide con <strong>{{ $dup['nombre'] }}</strong> ({{ $dup['email'] }}).
    </div>
    @endif

    {{-- Datos personales --}}
    <section class="mb-6">
        <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-3">Datos personales</h2>
        <div class="grid grid-cols-2 gap-x-8 gap-y-2">
            <div><span class="text-gray-400">Rol:</span> <span class="font-medium capitalize">{{ $u->role?->nombre }}</span></div>
            <div><span class="text-gray-400">Carnet:</span> <span class="font-mono">{{ $u->numero_carnet ?? '—' }}</span></div>
            <div><span class="text-gray-400">Teléfono:</span> {{ $u->telefono ?? '—' }}</div>
            <div><span class="text-gray-400">Nacimiento:</span> {{ $u->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</div>
            <div><span class="text-gray-400">Registrada:</span> {{ $u->created_at->format('d/m/Y H:i') }}</div>
            <div><span class="text-gray-400">Analizada:</span> {{ $u->analizado_en?->format('d/m/Y H:i') ?? '—' }}</div>
        </div>
    </section>

    {{-- Resultado IA --}}
    @if ($u->resultado_analisis)
        <section class="mb-6">
            <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-3">Resultado del análisis IA</h2>
            <div class="grid grid-cols-2 gap-x-8 gap-y-2">
                @php $f = $u->resultado_analisis['verificacion_facial'] ?? null; @endphp
                @php $vida = $u->resultado_analisis['deteccion_vida'] ?? null; @endphp
                @if ($vida)
                    <div><span class="text-gray-400">Detección de vida:</span> <span class="font-medium">{{ $vida['veredicto'] ?? '—' }}</span></div>
                    <div><span class="text-gray-400">Score vida:</span> {{ $vida['score'] ?? '—' }}</div>
                @endif
                @if ($f)
                    <div><span class="text-gray-400">Verificación facial:</span> <span class="font-medium">{{ $f['veredicto'] ?? '—' }}</span></div>
                    <div><span class="text-gray-400">Distancia:</span> {{ $f['distancia'] ?? '—' }}</div>
                @endif
                @if (!empty($u->resultado_analisis['motivo_rechazo']))
                    <div class="col-span-2 mt-1 p-2 bg-red-50 rounded border border-red-200 text-red-700">
                        <span class="font-medium">Motivo:</span> {{ $u->resultado_analisis['motivo_rechazo'] }}
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- Vehículo --}}
    @if ($u->vehiculo)
        <section class="mb-6">
            <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-3">Vehículo declarado</h2>
            <div class="grid grid-cols-2 gap-x-8 gap-y-2">
                <div><span class="text-gray-400">Placa:</span> <span class="font-mono font-bold uppercase">{{ $u->vehiculo->placa }}</span></div>
                <div><span class="text-gray-400">Marca/Modelo:</span> {{ $u->vehiculo->marca_modelo }}</div>
                @if ($u->vehiculo->color)
                    <div><span class="text-gray-400">Color:</span> {{ $u->vehiculo->color }}</div>
                @endif
                @if ($u->vehiculo->anio)
                    <div><span class="text-gray-400">Año:</span> {{ $u->vehiculo->anio }}</div>
                @endif
                <div><span class="text-gray-400">Relación:</span> <span class="capitalize">{{ $u->vehiculo->relacion_declarada }}</span></div>
            </div>
        </section>
    @endif

    {{-- Historial de revisiones --}}
    @if ($u->revisiones->count())
        <section class="mb-6">
            <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-3">Historial de revisiones administrativas</h2>
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-1 font-medium text-gray-500">Fecha</th>
                        <th class="text-left py-1 font-medium text-gray-500">Decisión</th>
                        <th class="text-left py-1 font-medium text-gray-500">Administrador</th>
                        <th class="text-left py-1 font-medium text-gray-500">Observación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($u->revisiones as $rev)
                        <tr class="border-b border-gray-100">
                            <td class="py-1 text-gray-500">{{ $rev->created_at->format('d/m/Y') }}</td>
                            <td class="py-1 font-medium capitalize">{{ $rev->decision }}</td>
                            <td class="py-1">{{ $rev->administrador?->name ?? '—' }}</td>
                            <td class="py-1 text-gray-500">{{ $rev->observacion ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    @endif

    {{-- Footer --}}
    <div class="border-t border-gray-200 pt-4 mt-6 text-xs text-gray-400 flex justify-between">
        <span>Lady's On Go · Panel Administrativo</span>
        <span>Generado el {{ now()->format('d/m/Y \a \l\a\s H:i') }}</span>
    </div>

    <script class="no-print">window.onload = () => window.print();</script>
</body>
</html>
