<x-guest-layout>
    <x-auth-split titulo="Confirma que eres tú" subtitulo="Paso 3 de 3 · Verificación facial">

        <ul class="steps w-full mb-6">
            <li class="step step-primary text-xs">Datos</li>
            <li class="step step-primary text-xs">Carnet</li>
            <li class="step step-primary text-xs">Selfie</li>
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
            <span class="text-sm">Mira a la cámara con buena iluminación, sin gorra ni lentes oscuros.</span>
        </div>

        <form id="form-selfie" method="POST" action="{{ route('registro.selfie') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="relative rounded-2xl overflow-hidden bg-black aspect-square">
                <video id="video" autoplay playsinline muted class="w-full h-full object-cover"></video>
                <canvas id="canvas" class="hidden"></canvas>
                <img id="preview" class="hidden absolute inset-0 w-full h-full object-cover" alt="">

                {{-- Guía facial --}}
                <div id="guia" class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-2/3 aspect-[3/4] rounded-full border-4 border-white/60 border-dashed"></div>
                </div>

                <div id="error-camara" class="hidden absolute inset-0 flex items-center justify-center bg-base-300 text-center p-6">
                    <div>
                        <p class="font-semibold mb-2">No se pudo acceder a la cámara</p>
                        <p class="text-sm text-base-content/70">Verifica los permisos del navegador o sube una foto.</p>
                    </div>
                </div>
            </div>

            <input type="file" id="selfie-file" name="selfie" accept="image/*" class="hidden" required>

            <div id="botones-camara" class="flex gap-2">
                <button type="button" id="btn-capturar" class="btn btn-primary flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Tomar foto
                </button>
                <label for="selfie-file" class="btn btn-ghost">Subir</label>
            </div>

            <div id="botones-confirmar" class="hidden flex gap-2">
                <button type="button" id="btn-repetir" class="btn btn-ghost flex-1">Repetir</button>
                <button type="submit" id="btn-enviar" class="btn btn-primary flex-1">Enviar</button>
            </div>

            <a href="{{ route('registro.carnet') }}" class="link link-hover text-sm block text-center">Volver</a>
        </form>

        <script>
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const preview = document.getElementById('preview');
            const guia = document.getElementById('guia');
            const errorCamara = document.getElementById('error-camara');
            const fileInput = document.getElementById('selfie-file');
            const botonesCamara = document.getElementById('botones-camara');
            const botonesConfirmar = document.getElementById('botones-confirmar');
            const btnCapturar = document.getElementById('btn-capturar');
            const btnRepetir = document.getElementById('btn-repetir');

            let stream = null;

            async function iniciarCamara() {
                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 720 }, height: { ideal: 720 } },
                        audio: false,
                    });
                    video.srcObject = stream;
                } catch (e) {
                    video.classList.add('hidden');
                    guia.classList.add('hidden');
                    errorCamara.classList.remove('hidden');
                }
            }

            function detenerCamara() {
                if (stream) {
                    stream.getTracks().forEach(t => t.stop());
                    stream = null;
                }
            }

            btnCapturar.addEventListener('click', () => {
                const w = video.videoWidth;
                const h = video.videoHeight;
                canvas.width = w;
                canvas.height = h;
                const ctx = canvas.getContext('2d');
                // Voltear horizontalmente (la cámara frontal viene espejada)
                ctx.translate(w, 0);
                ctx.scale(-1, 1);
                ctx.drawImage(video, 0, 0, w, h);

                canvas.toBlob((blob) => {
                    const file = new File([blob], 'selfie.jpg', { type: 'image/jpeg' });
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    fileInput.files = dt.files;

                    preview.src = URL.createObjectURL(blob);
                    preview.classList.remove('hidden');
                    video.classList.add('hidden');
                    guia.classList.add('hidden');
                    botonesCamara.classList.add('hidden');
                    botonesConfirmar.classList.remove('hidden');
                    detenerCamara();
                }, 'image/jpeg', 0.92);
            });

            btnRepetir.addEventListener('click', () => {
                preview.classList.add('hidden');
                video.classList.remove('hidden');
                guia.classList.remove('hidden');
                botonesConfirmar.classList.add('hidden');
                botonesCamara.classList.remove('hidden');
                fileInput.value = '';
                iniciarCamara();
            });

            fileInput.addEventListener('change', (e) => {
                const file = e.target.files?.[0];
                if (!file) return;
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                video.classList.add('hidden');
                guia.classList.add('hidden');
                botonesCamara.classList.add('hidden');
                botonesConfirmar.classList.remove('hidden');
                detenerCamara();
            });

            // Estilo espejo en preview del video (no en la captura final)
            video.style.transform = 'scaleX(-1)';

            iniciarCamara();
        </script>
    </x-auth-split>
</x-guest-layout>