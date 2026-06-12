@php
    $clases = [
        'verificada' => 'badge-success',
        'analizando' => 'badge-info',
        'pendiente'  => 'badge-warning',
        'rechazada'  => 'badge-error',
    ];
    $clase = $clases[$estado] ?? 'badge-ghost';
@endphp
<span class="badge {{ $clase }}">{{ ucfirst($estado) }}</span>