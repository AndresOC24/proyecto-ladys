@extends('layouts.admin')

@section('contenido')
@php
    $registro = $u->registros()->with(['documentos.datos', 'resultados.parametro'])->first();
@endphp

{{-- Breadcrumbs --}}
<div class="text-sm breadcrumbs mb-4">
    <ul>
        <li><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li><a href="{{ route('admin.usuarias') }}">Usuarias</a></li>
        <li class="truncate max-w-50">{{ $u->name }}</li>
    </ul>
</div>

{{-- Alerta de posible duplicado (Solución C) --}}
@php $dup = $u->resultado_analisis['posible_duplicado'] ?? null; @endphp
@if ($dup)
<div role="alert" class="alert alert-error mb-4 flex-col items-start gap-1">
    <div class="flex items-center gap-2 font-bold">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        Posible cuenta duplicada detectada por OCR
    </div>
    <p class="text-sm">
        El número de carnet extraído del documento (<span class="font-mono font-bold">{{ $u->resultado_analisis['numero_extraido'] ?? '—' }}</span>)
        ya pertenece a otra usuaria registrada:
        <a href="{{ route('admin.usuaria.ver', $dup['user_id']) }}" class="font-bold underline">
            {{ $dup['nombre'] }}
        </a>
        ({{ $dup['email'] }} · estado: <span class="capitalize">{{ $dup['estado'] }}</span>).
    </p>
    <p class="text-xs opacity-80">Revisá ambas fichas antes de aprobar esta solicitud. Si es la misma persona, eliminá la cuenta más reciente.</p>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Datos --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">{{ $u->name }}</h1>
                        <p class="text-base-content/60">{{ $u->email }}</p>
                    </div>
                    @include('admin.partials.badge-estado', ['estado' => $u->estado_verificacion])
                </div>

                <div class="divider my-2"></div>

                <dl class="grid grid-cols-2 gap-y-3 gap-x-6 text-sm">
                    <div><dt class="text-base-content/60">Rol</dt><dd class="font-medium">{{ $u->role?->nombre }}</dd></div>
                    <div><dt class="text-base-content/60">Teléfono</dt><dd class="font-medium">{{ $u->telefono ?? '—' }}</dd></div>
                    <div><dt class="text-base-content/60">N° Carnet declarado</dt><dd class="font-mono">{{ $u->numero_carnet }}</dd></div>
                    <div><dt class="text-base-content/60">N° Carnet extraído (OCR)</dt><dd class="font-mono">{{ $u->resultado_analisis['numero_extraido'] ?? '—' }}</dd></div>
                    <div><dt class="text-base-content/60">Fecha de nacimiento</dt><dd>{{ $u->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</dd></div>
                    <div><dt class="text-base-content/60">Registrada</dt><dd>{{ $u->created_at->format('d/m/Y H:i') }}</dd></div>
                    <div><dt class="text-base-content/60">Analizada</dt><dd>{{ $u->analizado_en?->format('d/m/Y H:i') ?? '—' }}</dd></div>
                </dl>
            </div>
        </div>

        {{-- Datos OCR normalizados (dato_documento) --}}
        @if ($registro)
            @php $docAnverso = $registro->documentos->firstWhere('tipo_documento', 'cedula_anverso'); @endphp
            @if ($docAnverso && $docAnverso->datos->count())
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title">Datos extraídos por OCR</h2>
                        <div class="flex items-center gap-2 mb-3">
                            @if ($docAnverso->calidad_legible === true)
                                <span class="badge badge-success badge-sm">Imagen legible</span>
                            @elseif ($docAnverso->calidad_legible === false)
                                <span class="badge badge-error badge-sm">Imagen no legible</span>
                            @endif
                        </div>
                        <dl class="grid grid-cols-2 gap-y-2 gap-x-6 text-sm">
                            @foreach ($docAnverso->datos as $dato)
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
                        <h2 class="card-title">Resultados granulares de validación</h2>
                        <div class="space-y-2 mt-2">
                            @foreach ($registro->resultados as $r)
                                @php
                                    $rc = match ($r->resultado) {
                                        'aprobado'  => 'border-success/40 bg-success/5',
                                        'rechazado' => 'border-error/40 bg-error/5',
                                        'observado' => 'border-warning/40 bg-warning/5',
                                        default     => 'border-base-300',
                                    };
                                    $badge = match ($r->resultado) {
                                        'aprobado'  => 'badge-success',
                                        'rechazado' => 'badge-error',
                                        'observado' => 'badge-warning',
                                        default     => 'badge-ghost',
                                    };
                                @endphp
                                <div class="border rounded-lg p-2 text-sm {{ $rc }}">
                                    <div class="flex items-center gap-2">
                                        <span class="badge {{ $badge }} badge-sm">{{ ucfirst($r->resultado) }}</span>
                                        @if ($r->parametro)
                                            <span class="font-medium">{{ $r->parametro->nombre_parametro }}</span>
                                            <span class="badge badge-ghost badge-xs">{{ $r->parametro->categoria }}</span>
                                        @endif
                                    </div>
                                    @if ($r->detalle)
                                        <div class="text-base-content/60 mt-1 text-xs">{{ $r->detalle }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endif

        {{-- Resultado IA --}}
        @if ($u->resultado_analisis)
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Resultado del análisis</h2>

                    @php $f = $u->resultado_analisis['verificacion_facial'] ?? null; @endphp
                    @php $vida = $u->resultado_analisis['deteccion_vida'] ?? null; @endphp
                    @if ($vida)
                        <div class="divider my-2">Detección de vida</div>
                        <div class="grid grid-cols-2 gap-y-2 gap-x-6 text-sm">
                            <div><dt class="text-base-content/60">Veredicto</dt><dd class="font-semibold">{{ $vida['veredicto'] ?? '—' }}</dd></div>
                            <div><dt class="text-base-content/60">Score</dt><dd class="font-mono">{{ $vida['score'] ?? '—' }} (umbral {{ $vida['umbral'] ?? '—' }})</dd></div>
                        </div>
                        @if ($vida['error'] ?? false)
                            <div class="text-error text-xs mt-1">{{ $vida['error'] }}</div>
                        @endif
                    @endif


                    @php $vida = $u->resultado_analisis['deteccion_vida'] ?? null; @endphp
                    @if ($f)
                        <div class="grid grid-cols-2 gap-y-2 gap-x-6 text-sm">
                            <div><dt class="text-base-content/60">Veredicto facial</dt><dd class="font-semibold">{{ $f['veredicto'] ?? '—' }}</dd></div>
                            <div><dt class="text-base-content/60">Distancia</dt><dd class="font-mono">{{ $f['distancia'] ?? '—' }} (umbral {{ $f['umbral_aprobar'] ?? '—' }})</dd></div>
                            <div><dt class="text-base-content/60">Modelo</dt><dd>{{ $f['modelo'] ?? '—' }}</dd></div>
                            <div><dt class="text-base-content/60">Detector</dt><dd>{{ $f['detector'] ?? '—' }}</dd></div>
                        </div>
                    @endif

                    @php $ctrl = $u->resultado_analisis['parametros_control'] ?? null; @endphp
                    @if ($ctrl)
                        <div class="divider my-2">Parámetros de control</div>
                        <div class="grid grid-cols-2 gap-y-2 gap-x-6 text-sm">
                            <div>
                                <dt class="text-base-content/60">Vigencia</dt>
                                <dd class="font-semibold">
                                    @if (($ctrl['vigente'] ?? null) === true) Vigente
                                    @elseif (($ctrl['vigente'] ?? null) === false) Vencido
                                    @else No determinada @endif
                                </dd>
                            </div>
                            <div><dt class="text-base-content/60">Expira</dt><dd class="font-mono">{{ $ctrl['fecha_expiracion'] ?? '—' }}</dd></div>
                        </div>
                        @foreach ($ctrl['errores'] ?? [] as $err)
                            <div class="text-error text-xs mt-1">{{ $err }}</div>
                        @endforeach
                    @endif

                    @php $lic = $u->resultado_analisis['validacion_licencia'] ?? null; @endphp
                    @if ($lic)
                        <div class="divider my-2">Licencia profesional</div>
                        <div class="grid grid-cols-2 gap-y-2 gap-x-6 text-sm">
                            <div><dt class="text-base-content/60">Veredicto</dt><dd class="font-semibold">{{ $lic['veredicto'] ?? '—' }}</dd></div>
                            <div><dt class="text-base-content/60">Categoría</dt><dd class="font-mono">{{ $lic['categoria'] ?? '—' }}</dd></div>
                            <div><dt class="text-base-content/60">¿Es licencia?</dt><dd>{{ ($lic['es_licencia'] ?? false) ? 'Sí' : 'No' }}</dd></div>
                            <div><dt class="text-base-content/60">¿Profesional?</dt>
                                <dd>@if (($lic['profesional'] ?? null) === true) Sí @elseif (($lic['profesional'] ?? null) === false) No @else Indeterminado @endif</dd>
                            </div>
                        </div>
                        @if ($lic['error'] ?? false)
                            <div class="text-error text-xs mt-1">{{ $lic['error'] }}</div>
                        @endif
                    @endif

                    @if (! empty($u->resultado_analisis['motivo_rechazo']))
                        <div role="alert" class="alert alert-warning mt-3">
                            <span class="text-sm">{{ $u->resultado_analisis['motivo_rechazo'] }}</span>
                        </div>
                    @endif

                    <details class="mt-4">
                        <summary class="cursor-pointer text-sm text-base-content/60">Ver datos OCR completos</summary>
                        <pre class="text-xs bg-base-200 p-3 mt-2 rounded overflow-x-auto">{{ json_encode($u->resultado_analisis, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </details>
                </div>
            </div>
        @endif

        {{-- Vehículo (solo conductoras que lo declararon) --}}
        @if ($u->vehiculo)
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 100-4 2 2 0 000 4zm8 0a2 2 0 100-4 2 2 0 000 4zm-8-7h8m-9-2l1-4h10l1 4"/></svg>
                        Vehículo declarado
                    </h2>
                    <div class="grid grid-cols-2 gap-y-2 gap-x-6 text-sm mt-2">
                        <div><dt class="text-base-content/60">Placa</dt><dd class="font-mono uppercase font-bold">{{ $u->vehiculo->placa }}</dd></div>
                        <div><dt class="text-base-content/60">Marca/Modelo</dt><dd>{{ $u->vehiculo->marca_modelo }}</dd></div>
                        @if ($u->vehiculo->color)
                        <div><dt class="text-base-content/60">Color</dt><dd class="capitalize">{{ $u->vehiculo->color }}</dd></div>
                        @endif
                        @if ($u->vehiculo->anio)
                        <div><dt class="text-base-content/60">Año</dt><dd>{{ $u->vehiculo->anio }}</dd></div>
                        @endif
                        <div><dt class="text-base-content/60">Relación</dt><dd class="capitalize">{{ $u->vehiculo->relacion_declarada }}</dd></div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Imágenes --}}
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">Documentos</h2>
                @php
                    $docs = ['anverso' => $u->carnet_anverso_path, 'reverso' => $u->carnet_reverso_path, 'selfie' => $u->selfie_path];
                    if ($u->licencia_path) { $docs['licencia'] = $u->licencia_path; }
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($docs as $tipo => $path)
                        <div>
                            <div class="text-xs font-semibold uppercase text-base-content/60 mb-1">{{ $tipo }}</div>
                            @if ($path)
                                <a href="{{ route('admin.usuaria.imagen', [$u, $tipo]) }}" target="_blank">
                                    <img src="{{ route('admin.usuaria.imagen', [$u, $tipo]) }}"
                                         class="rounded-lg w-full h-40 object-cover hover:opacity-80 transition" alt="{{ $tipo }}">
                                </a>
                            @else
                                <div class="rounded-lg w-full h-40 bg-base-200 flex items-center justify-center text-base-content/40 text-sm">Sin imagen</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Acciones --}}
    <div class="space-y-4">
        <a href="{{ route('admin.usuaria.imprimir', $u) }}" target="_blank"
           class="btn btn-ghost btn-sm w-full gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Imprimir ficha
        </a>

        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">Acciones</h2>

                <form method="POST" action="{{ route('admin.usuaria.aprobar', $u) }}">
                    @csrf
                    <button class="btn btn-success w-full"
                            @disabled($u->estado_verificacion === 'verificada')>
                        Aprobar
                    </button>
                </form>

                <button class="btn btn-error w-full" onclick="modalRechazar.showModal()"
                        @disabled($u->estado_verificacion === 'rechazada')>
                    Rechazar
                </button>

                <form method="POST" action="{{ route('admin.usuaria.reanalizar', $u) }}">
                    @csrf
                    <button class="btn btn-ghost w-full">Re-analizar con IA</button>
                </form>
            </div>
        </div>

        {{-- Gestión de cuenta --}}
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">
                    Gestión de cuenta
                    @if ($u->activa)
                        <span class="badge badge-success badge-sm">Activa</span>
                    @else
                        <span class="badge badge-error badge-sm">Desactivada</span>
                    @endif
                </h2>

                {{-- Desactivar / Reactivar --}}
                @if ($u->activa)
                    <form method="POST" action="{{ route('admin.usuaria.desactivar', $u) }}">
                        @csrf
                        <button class="btn btn-warning w-full" @disabled($u->id === auth()->id())>Desactivar usuaria</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.usuaria.reactivar', $u) }}">
                        @csrf
                        <button class="btn btn-success w-full">Reactivar usuaria</button>
                    </form>
                @endif

                {{-- Asignar rol --}}
                <div class="divider my-2">Rol</div>
                <form method="POST" action="{{ route('admin.usuaria.rol', $u) }}" class="space-y-2">
                    @csrf
                    <select name="rol" class="select select-bordered w-full">
                        @foreach (\App\Models\Role::orderBy('nombre')->pluck('nombre') as $rol)
                            <option value="{{ $rol }}" @selected($u->role?->nombre === $rol)>{{ ucfirst($rol) }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-neutral w-full">Asignar rol</button>
                </form>

                {{-- Eliminar cuenta (permanente) --}}
                <div class="divider my-2 text-error/70">Zona de peligro</div>
                <button class="btn btn-outline btn-error w-full" onclick="modalEliminar.showModal()"
                        @disabled($u->id === auth()->id())>
                    Eliminar cuenta
                </button>
            </div>
        </div>

        {{-- Histórico de revisiones (tabla relacional) --}}
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">Historial de revisiones</h2>
                @if ($u->revisiones->isEmpty())
                    <p class="text-sm text-base-content/60">Sin revisiones manuales todavía.</p>
                @else
                    <ul class="space-y-3 mt-2">
                        @foreach ($u->revisiones as $rev)
                            @php
                                $badge = match ($rev->decision) {
                                    'aprobada'  => 'badge-success',
                                    'rechazada' => 'badge-error',
                                    'reanalisis'=> 'badge-info',
                                    'reenvio'   => 'badge-warning',
                                    default     => 'badge-ghost',
                                };
                            @endphp
                            <li class="border-l-2 border-base-300 pl-3">
                                <div class="flex items-center gap-2">
                                    <span class="badge {{ $badge }} badge-sm">{{ ucfirst($rev->decision) }}</span>
                                    <time class="text-xs text-base-content/60">{{ $rev->created_at->format('d/m/Y H:i') }}</time>
                                </div>
                                <div class="text-xs text-base-content/70 mt-0.5">
                                    {{ $rev->administrador?->name ?? '—' }}
                                    <span class="text-base-content/40">({{ $rev->administrador?->email }})</span>
                                </div>
                                @if ($rev->observacion)
                                    <div class="text-xs mt-1 italic text-base-content/80">"{{ $rev->observacion }}"</div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

<dialog id="modalRechazar" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-3">Rechazar registro</h3>
        <form method="POST" action="{{ route('admin.usuaria.rechazar', $u) }}">
            @csrf
            <label class="floating-label">
                <span>Motivo del rechazo</span>
                <textarea name="motivo" class="textarea textarea-bordered w-full" rows="3" required placeholder="Motivo del rechazo"></textarea>
            </label>
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="modalRechazar.close()">Cancelar</button>
                <button type="submit" class="btn btn-error">Rechazar</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>cerrar</button></form>
</dialog>

<dialog id="modalEliminar" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg text-error mb-2">Eliminar cuenta permanentemente</h3>
        <p class="text-sm text-base-content/70">
            Esta acción <strong>no se puede deshacer</strong>. Se eliminará la cuenta de
            <strong>{{ $u->name }}</strong> junto con sus documentos (carnet, selfie y licencia).
        </p>
        <form method="POST" action="{{ route('admin.usuaria.eliminar', $u) }}" class="modal-action">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-ghost" onclick="modalEliminar.close()">Cancelar</button>
            <button type="submit" class="btn btn-error">Sí, eliminar</button>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>cerrar</button></form>
</dialog>
@endsection