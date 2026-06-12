<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @php $user = auth()->user(); @endphp

            @if (! $user->esAdministrador())
                <div id="estado-card">
                    @include('partials.estado-verificacion', ['user' => $user])
                </div>
            @endif

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">¡Bienvenida, {{ $user->name }}!</h2>
                    <p class="text-base-content/70">Tu rol: <span class="badge badge-primary">{{ $user->role?->nombre ?? 'sin rol' }}</span></p>
                </div>
            </div>
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