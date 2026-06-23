<x-app-layout>
    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h1 class="card-title text-xl">Reenviar documentos</h1>
                    <p class="text-base-content/70 text-sm">
                        Puedes subir nuevas fotos para que tu registro sea analizado nuevamente.
                        Solo carga los documentos que deseas actualizar; los que no subas se mantendrán.
                    </p>

                    @if ($errors->any())
                        <div role="alert" class="alert alert-error mt-2">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('registro.reenviar') }}" enctype="multipart/form-data" class="space-y-5 mt-4">
                        @csrf

                        {{-- Corrección de datos declarados --}}
                        <div x-data="{ abierto: false }" class="border border-base-300 rounded-xl">
                            <button type="button" @click="abierto = !abierto"
                                    class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium hover:bg-base-200 rounded-xl transition">
                                <span>¿Necesitas corregir un dato declarado?</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform" :class="abierto ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="abierto" x-transition class="px-4 pb-4 space-y-4 border-t border-base-300 pt-4">
                                <p class="text-xs text-base-content/60">Dejá en blanco los campos que no necesitas modificar. Solo cambiá lo que está incorrecto.</p>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Fecha de nacimiento</span>
                                        <span class="label-text-alt text-base-content/50">Actual: {{ $user->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</span>
                                    </label>
                                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                                           class="input input-bordered @error('fecha_nacimiento') input-error @enderror">
                                    @error('fecha_nacimiento')
                                        <div class="label"><span class="label-text-alt text-error">{{ $message }}</span></div>
                                    @enderror
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Número de carnet</span>
                                        <span class="label-text-alt text-base-content/50">Actual: {{ $user->numero_carnet ?? '—' }}</span>
                                    </label>
                                    <input type="text" name="numero_carnet" value="{{ old('numero_carnet') }}"
                                           placeholder="Ej: 9642545"
                                           class="input input-bordered font-mono @error('numero_carnet') input-error @enderror">
                                    @error('numero_carnet')
                                        <div class="label"><span class="label-text-alt text-error">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="divider text-xs">Documentos</div>

                        {{-- Cédula anverso --}}
                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Cédula — anverso</span></label>
                            <input type="file" name="anverso" accept="image/jpeg,image/png"
                                   class="file-input file-input-bordered w-full @error('anverso') input-error @enderror">
                            @if ($user->carnet_anverso_path)
                                <div class="label"><span class="label-text-alt text-success">Ya tienes una foto guardada</span></div>
                            @endif
                        </div>

                        {{-- Cédula reverso --}}
                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Cédula — reverso</span></label>
                            <input type="file" name="reverso" accept="image/jpeg,image/png"
                                   class="file-input file-input-bordered w-full @error('reverso') input-error @enderror">
                            @if ($user->carnet_reverso_path)
                                <div class="label"><span class="label-text-alt text-success">Ya tienes una foto guardada</span></div>
                            @endif
                        </div>

                        {{-- Selfie --}}
                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Foto selfie</span></label>
                            <input type="file" name="selfie" accept="image/jpeg,image/png"
                                   class="file-input file-input-bordered w-full @error('selfie') input-error @enderror">
                            @if ($user->selfie_path)
                                <div class="label"><span class="label-text-alt text-success">Ya tienes una foto guardada</span></div>
                            @endif
                        </div>

                        @if ($esConductora)
                            {{-- Licencia --}}
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Licencia de conducir</span></label>
                                <input type="file" name="licencia" accept="image/jpeg,image/png"
                                       class="file-input file-input-bordered w-full @error('licencia') input-error @enderror">
                                @if ($user->licencia_path)
                                    <div class="label"><span class="label-text-alt text-success">Ya tienes una foto guardada</span></div>
                                @endif
                            </div>
                        @endif

                        <div class="flex gap-3 pt-2">
                            <a href="{{ route('dashboard') }}" class="btn btn-ghost flex-1">Cancelar</a>
                            <button type="submit" class="btn btn-primary flex-1">Enviar para análisis</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
