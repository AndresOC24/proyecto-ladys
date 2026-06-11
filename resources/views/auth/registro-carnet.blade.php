<x-guest-layout>
    <x-auth-split titulo="Verifica tu identidad" subtitulo="Paso 2 de 3 · Carnet de identidad">

        <ul class="steps w-full mb-6">
            <li class="step step-primary text-xs">Datos</li>
            <li class="step step-primary text-xs">Carnet</li>
            <li class="step text-xs">Selfie</li>
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

        <div role="alert" class="alert alert-info mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="text-sm">Toma fotos claras, sin reflejos, con todo el carnet visible.</span>
        </div>

        <form method="POST" action="{{ route('registro.carnet') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="label">
                    <span class="label-text font-semibold">Anverso (frente)</span>
                </label>
                <label for="anverso" class="block cursor-pointer">
                    <div id="dropzone-anverso" class="border-2 border-dashed border-base-300 rounded-xl p-6 text-center hover:border-primary transition">
                        <img id="preview-anverso" class="rounded-lg max-h-40 mx-auto mb-2 hidden" alt="">
                        <div id="placeholder-anverso">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto text-base-content/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            <p class="text-sm mt-1">Toca para tomar foto o subir imagen</p>
                            <p class="text-xs text-base-content/50">JPG o PNG · Máx 5 MB</p>
                        </div>
                    </div>
                </label>
                <input id="anverso" type="file" name="anverso" accept="image/*" capture="environment"
                       class="hidden" onchange="previsualizar(this, 'preview-anverso', 'placeholder-anverso')" required>
            </div>

            <div>
                <label class="label">
                    <span class="label-text font-semibold">Reverso (parte trasera)</span>
                </label>
                <label for="reverso" class="block cursor-pointer">
                    <div id="dropzone-reverso" class="border-2 border-dashed border-base-300 rounded-xl p-6 text-center hover:border-primary transition">
                        <img id="preview-reverso" class="rounded-lg max-h-40 mx-auto mb-2 hidden" alt="">
                        <div id="placeholder-reverso">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto text-base-content/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            <p class="text-sm mt-1">Toca para tomar foto o subir imagen</p>
                            <p class="text-xs text-base-content/50">JPG o PNG · Máx 5 MB</p>
                        </div>
                    </div>
                </label>
                <input id="reverso" type="file" name="reverso" accept="image/*" capture="environment"
                       class="hidden" onchange="previsualizar(this, 'preview-reverso', 'placeholder-reverso')" required>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('register') }}" class="btn btn-ghost flex-1">Volver</a>
            <button type="submit" class="btn btn-primary flex-1">Continuar</button>
            </div>
        </form>

        <script>
            function previsualizar(input, imgId, placeholderId) {
                const file = input.files?.[0];
                if (!file) return;
                const img = document.getElementById(imgId);
                const ph = document.getElementById(placeholderId);
                const reader = new FileReader();
                reader.onload = e => {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    ph.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        </script>
    </x-auth-split>
</x-guest-layout>