@props(['titulo' => '', 'subtitulo' => ''])

<div class="min-h-screen grid lg:grid-cols-2">
    {{-- Panel izquierdo: branding --}}
    <div class="hidden lg:flex relative overflow-hidden bg-gradient-to-br from-pink-500 via-fuchsia-500 to-purple-600 text-white p-12 flex-col justify-between">
        <div>
            <a href="/" class="flex items-center gap-2 text-2xl font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                </svg>
                <span>Lady's On Go</span>
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
                <a href="/" class="text-xl font-bold text-primary">Lady's On Go</a>
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