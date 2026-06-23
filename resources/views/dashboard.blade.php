<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @php $user = auth()->user(); @endphp

            {{-- Estado de verificación --}}
            @if (! $user->esAdministrador())
                <div id="estado-card">
                    @include('partials.estado-verificacion', ['user' => $user])
                </div>
            @endif

            {{-- Bienvenida / perfil post-verificación --}}
            @if ($user->estado_verificacion === 'verificada')
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title">¡Bienvenida, {{ $user->name }}!</h2>
                        <p class="text-base-content/70 text-sm">
                            Tu cuenta está verificada como
                            <span class="badge badge-primary badge-sm">{{ $user->role?->nombre }}</span>.
                        </p>

                        <div class="divider my-2"></div>

                        <dl class="grid grid-cols-2 gap-y-2 gap-x-4 text-sm">
                            <div>
                                <dt class="text-base-content/60">Nombre completo</dt>
                                <dd class="font-medium">{{ $user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-base-content/60">Correo</dt>
                                <dd class="font-medium">{{ $user->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-base-content/60">N° Carnet</dt>
                                <dd class="font-mono">{{ $user->numero_carnet }}</dd>
                            </div>
                            <div>
                                <dt class="text-base-content/60">Teléfono</dt>
                                <dd>{{ $user->telefono ?? '—' }}</dd>
                            </div>
                        </dl>

                        <div class="mt-3">
                            <a href="{{ route('mi-perfil') }}" class="btn btn-outline btn-sm">Ver perfil completo</a>
                        </div>
                    </div>
                </div>

                {{-- Vehículo (solo conductoras) --}}
                @if ($user->vehiculo)
                    <div class="card bg-base-100 shadow">
                        <div class="card-body">
                            <h2 class="card-title text-base">Vehículo registrado</h2>
                            <dl class="grid grid-cols-2 gap-y-2 gap-x-4 text-sm mt-1">
                                <div>
                                    <dt class="text-base-content/60">Placa</dt>
                                    <dd class="font-mono uppercase font-semibold">{{ $user->vehiculo->placa }}</dd>
                                </div>
                                <div>
                                    <dt class="text-base-content/60">Marca / Modelo</dt>
                                    <dd>{{ $user->vehiculo->marca_modelo }}</dd>
                                </div>
                                <div>
                                    <dt class="text-base-content/60">Color</dt>
                                    <dd>{{ $user->vehiculo->color }}</dd>
                                </div>
                                <div>
                                    <dt class="text-base-content/60">Año</dt>
                                    <dd>{{ $user->vehiculo->anio }}</dd>
                                </div>
                                <div>
                                    <dt class="text-base-content/60">Relación declarada</dt>
                                    <dd class="capitalize">{{ $user->vehiculo->relacion_declarada }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                @endif

            @else
                {{-- Estado no verificado: solo bienvenida simple --}}
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title">¡Bienvenida, {{ $user->name }}!</h2>
                        <p class="text-base-content/70">Tu rol: <span class="badge badge-primary">{{ $user->role?->nombre ?? 'sin rol' }}</span></p>
                    </div>
                </div>
            @endif

        </div>
    </div>

    @if (! $user->esAdministrador() && $user->estado_verificacion === 'analizando')
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
