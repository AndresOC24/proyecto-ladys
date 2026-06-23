<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-5">

            @php
                $user = auth()->user();
                $registro = $user->ultimoRegistro();
            @endphp

            {{-- Estado actual --}}
            <div id="estado-card">
                @include('partials.estado-verificacion', ['user' => $user])
            </div>

            {{-- Datos personales --}}
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Mis datos</h2>
                    <dl class="grid grid-cols-2 gap-y-3 gap-x-6 text-sm mt-2">
                        <div><dt class="text-base-content/60">Nombre</dt><dd class="font-medium">{{ $user->name }}</dd></div>
                        <div><dt class="text-base-content/60">Correo</dt><dd>{{ $user->email }}</dd></div>
                        <div><dt class="text-base-content/60">Teléfono</dt><dd>{{ $user->telefono ?? '—' }}</dd></div>
                        <div><dt class="text-base-content/60">N° Carnet declarado</dt><dd class="font-mono">{{ $user->numero_carnet }}</dd></div>
                        <div><dt class="text-base-content/60">Fecha de nacimiento</dt><dd>{{ $user->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</dd></div>
                        <div><dt class="text-base-content/60">Rol</dt><dd class="capitalize">{{ $user->role?->nombre ?? '—' }}</dd></div>
                    </dl>
                </div>
            </div>

            @if ($registro)
                {{-- Datos extraídos por OCR --}}
                @php
                    $docAnverso = $registro->documentos->firstWhere('tipo_documento', 'cedula_anverso');
                    $datoOcr = $docAnverso?->datos ?? collect();
                @endphp

                @if ($datoOcr->count())
                    <div class="card bg-base-100 shadow">
                        <div class="card-body">
                            <h2 class="card-title">Datos extraídos de tu cédula (OCR)</h2>
                            <p class="text-sm text-base-content/60 mb-3">Estos valores fueron leídos automáticamente de tu documento.</p>
                            <dl class="grid grid-cols-2 gap-y-3 gap-x-6 text-sm">
                                @foreach ($datoOcr as $dato)
                                    <div>
                                        <dt class="text-base-content/60 capitalize">{{ str_replace('_', ' ', $dato->nombre_campo) }}</dt>
                                        <dd class="font-mono">{{ $dato->valor_extraido ?? '—' }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                @endif

                {{-- Resultados de validación por parámetro --}}
                @if ($registro->resultados->count())
                    <div class="card bg-base-100 shadow">
                        <div class="card-body">
                            <h2 class="card-title">Resultados de validación</h2>
                            <div class="space-y-2 mt-2">
                                @foreach ($registro->resultados as $r)
                                    @php
                                        $badge = match ($r->resultado) {
                                            'aprobado' => 'badge-success',
                                            'rechazado' => 'badge-error',
                                            'observado' => 'badge-warning',
                                            default => 'badge-ghost',
                                        };
                                    @endphp
                                    <div class="flex items-start gap-3 text-sm border-b border-base-200 pb-2">
                                        <span class="badge {{ $badge }} badge-sm shrink-0 mt-0.5">{{ ucfirst($r->resultado) }}</span>
                                        <div>
                                            @if ($r->parametro)
                                                <div class="font-medium">{{ $r->parametro->nombre_parametro }}</div>
                                            @endif
                                            @if ($r->detalle)
                                                <div class="text-base-content/60">{{ $r->detalle }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Historial de registros de verificación --}}
                @if ($user->registros->count() > 1)
                    <div class="card bg-base-100 shadow">
                        <div class="card-body">
                            <h2 class="card-title">Historial de intentos de verificación</h2>
                            <div class="space-y-2 mt-2">
                                @foreach ($user->registros as $reg)
                                    @php
                                        $badge = match ($reg->estado_resultado) {
                                            'aprobado'  => 'badge-success',
                                            'rechazado' => 'badge-error',
                                            'observado' => 'badge-warning',
                                            'analizando'=> 'badge-info',
                                            default     => 'badge-ghost',
                                        };
                                    @endphp
                                    <div class="flex items-center gap-3 text-sm">
                                        <span class="badge {{ $badge }} badge-sm">{{ ucfirst($reg->estado_resultado) }}</span>
                                        <span class="text-base-content/60">{{ $reg->created_at->format('d/m/Y H:i') }}</span>
                                        <span class="capitalize text-base-content/50">{{ $reg->tipo_registro }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            {{-- Acciones disponibles --}}
            @if ($user->estado_verificacion === 'rechazada')
                <div class="card bg-base-100 shadow border border-error/30">
                    <div class="card-body">
                        <h2 class="card-title text-error">Acción requerida</h2>
                        <p class="text-sm text-base-content/70">Tu registro fue rechazado. Puedes volver a enviar tus documentos para una nueva evaluación.</p>
                        <div class="mt-3">
                            <a href="{{ route('registro.reenviar') }}" class="btn btn-primary">Reenviar documentos</a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    @if ($user->estado_verificacion === 'analizando')
        <script>
            const intervalId = setInterval(async () => {
                try {
                    const r = await fetch('{{ route('registro.estado') }}', { headers: { 'Accept': 'application/json' }});
                    const data = await r.json();
                    if (data.estado !== 'analizando') {
                        clearInterval(intervalId);
                        location.reload();
                    }
                } catch (e) { /* ignorar */ }
            }, 3000);
        </script>
    @endif
</x-app-layout>
