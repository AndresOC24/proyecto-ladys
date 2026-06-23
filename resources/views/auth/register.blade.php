<x-guest-layout>
    <x-auth-split titulo="Crear cuenta" subtitulo="Paso 1 de 2 · Datos personales">

        <ul class="steps w-full mb-6">
            <li class="step step-primary text-xs">Datos</li>
            <li class="step text-xs">Carnet</li>
        </ul>

        @if ($errors->any())
            <div role="alert" class="alert alert-error mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- Selector de rol --}}
            <div>
                <label class="label">
                    <span class="label-text font-semibold">Quiero registrarme como</span>
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="rol" value="pasajero" class="peer sr-only"
                               {{ old('rol', 'pasajero') === 'pasajero' ? 'checked' : '' }} required>
                        <div class="border-2 border-base-300 rounded-xl p-4 text-center transition
                                    peer-checked:border-primary peer-checked:bg-primary/5
                                    hover:border-primary/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div class="font-semibold text-sm">Pasajera</div>
                            <div class="text-xs text-base-content/60">Quiero viajar</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="rol" value="conductora" class="peer sr-only"
                               {{ old('rol') === 'conductora' ? 'checked' : '' }}>
                        <div class="border-2 border-base-300 rounded-xl p-4 text-center transition
                                    peer-checked:border-primary peer-checked:bg-primary/5
                                    hover:border-primary/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="font-semibold text-sm">Conductora</div>
                            <div class="text-xs text-base-content/60">Quiero conducir</div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="divider my-2"></div>

            <label class="floating-label">
                <span>Nombre completo</span>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nombre completo"
                       class="input input-bordered w-full" required autofocus>
            </label>

            <label class="floating-label">
                <span>Correo electrónico</span>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Correo electrónico"
                       class="input input-bordered w-full" required>
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="floating-label">
                    <span>Teléfono</span>
                    <input type="tel" name="telefono" value="{{ old('telefono') }}" placeholder="+591..."
                           class="input input-bordered w-full" required>
                </label>

                <label class="floating-label">
                    <span>Fecha de nacimiento</span>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                           class="input input-bordered w-full" required>
                </label>
            </div>

            <label class="floating-label">
                <span>Número de carnet</span>
                <input type="text" name="numero_carnet" value="{{ old('numero_carnet') }}" placeholder="Ej: 9642545"
                       class="input input-bordered w-full" required>
            </label>

            <div x-data="{
                pwd: '',
                get fuerza() {
                    const p = this.pwd;
                    if (p.length === 0) return 0;
                    let score = 0;
                    if (p.length >= 8)  score++;
                    if (p.length >= 12) score++;
                    if (/[A-Z]/.test(p)) score++;
                    if (/[0-9]/.test(p)) score++;
                    if (/[^A-Za-z0-9]/.test(p)) score++;
                    return Math.min(score, 4);
                },
                get etiqueta() {
                    return ['', 'Débil', 'Regular', 'Buena', 'Fuerte'][this.fuerza];
                },
                get color() {
                    return ['', 'bg-error', 'bg-warning', 'bg-info', 'bg-success'][this.fuerza];
                }
            }">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="floating-label">
                            <span>Contraseña</span>
                            <input type="password" name="password" placeholder="Contraseña"
                                   class="input input-bordered w-full" required
                                   x-model="pwd">
                        </label>
                        <div class="mt-2 space-y-1" x-show="pwd.length > 0">
                            <div class="flex gap-1">
                                <template x-for="i in 4">
                                    <div class="h-1.5 flex-1 rounded-full transition-colors"
                                         :class="i <= fuerza ? color : 'bg-base-300'"></div>
                                </template>
                            </div>
                            <div class="text-xs" :class="{
                                'text-error': fuerza === 1,
                                'text-warning': fuerza === 2,
                                'text-info': fuerza === 3,
                                'text-success': fuerza === 4
                            }" x-text="etiqueta"></div>
                        </div>
                    </div>

                    <label class="floating-label">
                        <span>Confirmar</span>
                        <input type="password" name="password_confirmation" placeholder="Repetir"
                               class="input input-bordered w-full" required>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-full">Continuar</button>

            <p class="text-center text-sm">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="link link-primary font-semibold">Inicia sesión</a>
            </p>
        </form>
    </x-auth-split>
</x-guest-layout>