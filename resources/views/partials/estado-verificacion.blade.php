@if ($user->estado_verificacion === 'analizando')
    <div role="alert" class="alert alert-info">
        <span class="loading loading-spinner"></span>
        <div>
            <h3 class="font-bold">Tu registro está siendo analizado</h3>
            <div class="text-sm">Estamos verificando tu documento. Esto puede tardar unos segundos.</div>
        </div>
    </div>
@elseif ($user->estado_verificacion === 'verificada')
    <div role="alert" class="alert alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <div>
            <h3 class="font-bold">¡Registro verificado!</h3>
            <div class="text-sm">El análisis de tus datos fue correcto. Ya puedes usar la plataforma.</div>
        </div>
    </div>
@elseif ($user->estado_verificacion === 'rechazada')
    <div role="alert" class="alert alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <div>
            <h3 class="font-bold">Registro rechazado</h3>
            <div class="text-sm">{{ $user->resultado_analisis['motivo_rechazo'] ?? 'Hubo un problema con la verificación.' }}</div>
        </div>
    </div>
@elseif ($user->estado_verificacion === 'pendiente')
    <div role="alert" class="alert alert-warning">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        <div>
            <h3 class="font-bold">Pendiente de revisión administrativa</h3>
            <div class="text-sm">{{ $user->resultado_analisis['motivo_rechazo'] ?? 'Tu registro requiere validación manual. Te notificaremos pronto.' }}</div>
        </div>
    </div>
@endif