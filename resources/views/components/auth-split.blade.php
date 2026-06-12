@props(['titulo' => '', 'subtitulo' => ''])

<div class="min-h-screen grid lg:grid-cols-2">
    {{-- Panel izquierdo: branding --}}
    <div class="hidden lg:flex relative overflow-hidden bg-gradient-to-br from-red-700 via-red-600 to-rose-800 text-white p-12 flex-col justify-between">
        <div>
            <a href="/" class="inline-flex items-center bg-white rounded-xl px-4 py-3 shadow-lg">
                <img src="{{ asset('images/logoLadys.png') }}" alt="Lady's On Go" class="h-12 w-auto">
            </a>
        </div>

        <div class="space-y-4 relative z-10">
            <h2 class="text-4xl font-bold leading-tight">Movilidad segura, para mujeres.</h2>
            <p class="text-white/80 text-lg">Verificación de identidad con inteligencia artificial. Cada conductora y pasajera es validada antes de unirse.</p>
        </div>

        <div class="text-sm text-white/60">© {{ date('Y') }} Lady's On Go · Santa Cruz de la Sierra</div>

        {{-- Decoración --}}
        <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute -top-20 -left-20 w-72 h-72 rounded-full bg-white/10 blur-3xl"></div>
    </div>

    {{-- Panel derecho: contenido --}}
    <div class="flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-md">
            {{-- Logo móvil --}}
            <div class="lg:hidden flex justify-center mb-6">
                <a href="/"><img src="{{ asset('images/logoLadys.png') }}" alt="Lady's On Go" class="h-12 w-auto"></a>
            </div>

            @if ($titulo)
                <div class="mb-6">
                    <h1 class="text-3xl font-bold">{{ $titulo }}</h1>
                    @if ($subtitulo)
                        <p class="text-base-content/60 mt-1">{{ $subtitulo }}</p>
                    @endif
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>