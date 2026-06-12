<x-guest-layout>
    <x-auth-split titulo="Licencia de conducir" subtitulo="Paso 4 de 4 · Licencia profesional">

        <ul class="steps w-full mb-6">
            <li class="step step-primary text-xs">Datos</li>
            <li class="step step-primary text-xs">Carnet</li>
            <li class="step step-primary text-xs">Selfie</li>
            <li class="step step-primary text-xs">Licencia</li>
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
            <span class="text-sm">Sube una foto clara de tu licencia de conducir <strong>profesional</strong>, con la categoría legible.</span>
        </div>

        <form method="POST" action="{{ route('registro.licencia') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="label">
                    <span class="label-text font-semibold">Licencia de conducir</span>
                </label>
                <label for="licencia" class="block cursor-pointer">
                    <div id="dropzone-licencia" class="border-2 border-dashed border-base-300 rounded-xl p-6 text-center hover:border-primary transition">
                        <img id="preview-licencia" class="rounded-lg max-h-40 mx-auto mb-2 hidden" alt="">
                        <div id="placeholder-licencia">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto text-base-content/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            <p class="text-sm mt-1">Toca para tomar foto o subir imagen</p>
                            <p class="text-xs text-base-content/50">JPG o PNG · Máx 5 MB</p>
                        </div>
                    </div>
                </label>
                <input id="licencia" type="file" name="licencia" accept="image/*" capture="environment"
                       class="hidden" onchange="previsualizar(this, 'preview-licencia', 'placeholder-licencia')" required>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('registro.selfie') }}" class="btn btn-ghost flex-1">Volver</a>
                <button type="submit" class="btn btn-primary flex-1">Finalizar registro</button>
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
