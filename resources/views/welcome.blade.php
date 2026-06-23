<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} — Transporte seguro para mujeres</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-100">

<nav class="navbar bg-base-100 border-b border-base-200 px-4 sm:px-8">
    <div class="flex-1">
        <img src="{{ asset('images/logoLadys.png') }}" alt="Lady's On Go" class="h-9 w-auto">
    </div>
    <div class="flex gap-2">
        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Iniciar sesión</a>
        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Registrarse</a>
    </div>
</nav>

<section class="hero min-h-[70vh] bg-gradient-to-br from-primary/10 via-base-100 to-secondary/10 px-4">
    <div class="hero-content text-center flex-col max-w-3xl">
        <div class="badge badge-primary badge-outline mb-4">Verificación de identidad con IA</div>
        <h1 class="text-4xl sm:text-5xl font-bold leading-tight">
            Transporte seguro<br>
            <span class="text-primary">diseñado para mujeres</span>
        </h1>
        <p class="text-base-content/70 text-lg mt-4 max-w-xl">
            Lady's On Go valida tu identidad con reconocimiento facial e inteligencia artificial
            antes de conectarte con conductoras verificadas. Tu seguridad, nuestra prioridad.
        </p>
        <div class="flex flex-wrap gap-3 justify-center mt-6">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Crear cuenta</a>
            <a href="{{ route('login') }}" class="btn btn-outline btn-lg">Ya tengo cuenta</a>
        </div>
    </div>
</section>

<section class="py-16 px-4 bg-base-200">
    <div class="max-w-5xl mx-auto">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-2">¿Cómo funciona la verificación?</h2>
        <p class="text-center text-base-content/60 mb-10 max-w-lg mx-auto">
            Un proceso automático que garantiza que cada usuaria es quien dice ser.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="card bg-base-100 shadow">
                <div class="card-body items-center text-center">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                    </div>
                    <h3 class="card-title text-base">OCR Documental</h3>
                    <p class="text-sm text-base-content/60">Lee automáticamente tu cédula boliviana y valida su estructura, fechas y formato.</p>
                </div>
            </div>
            <div class="card bg-base-100 shadow">
                <div class="card-body items-center text-center">
                    <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="card-title text-base">Reconocimiento Facial</h3>
                    <p class="text-sm text-base-content/60">Compara tu selfie en vivo con la foto de tu documento usando ArcFace.</p>
                </div>
            </div>
            <div class="card bg-base-100 shadow">
                <div class="card-body items-center text-center">
                    <div class="w-12 h-12 rounded-full bg-success/10 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="card-title text-base">Revisión Híbrida</h3>
                    <p class="text-sm text-base-content/60">Los casos dudosos son revisados por administradoras humanas en menos de 24 horas.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 px-4">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-center mb-10">¿Cómo quieres unirte?</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md transition-shadow">
                <div class="card-body">
                    <h3 class="card-title"><svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> Pasajera</h3>
                    <p class="text-sm text-base-content/60">Solo necesitas tu cédula de identidad y una selfie para verificar tu identidad.</p>
                    <div class="card-actions mt-3">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Registrarme como pasajera</a>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md transition-shadow">
                <div class="card-body">
                    <h3 class="card-title"><svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1m0-11h8m0 0l3 4M9 17H7m6 0h4"/></svg> Conductora</h3>
                    <p class="text-sm text-base-content/60">Además de tu cédula, necesitarás tu licencia de conducir y los datos de tu vehículo.</p>
                    <div class="card-actions mt-3">
                        <a href="{{ route('register') }}" class="btn btn-secondary btn-sm">Registrarme como conductora</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer footer-center py-8 bg-base-200 text-base-content/60 text-sm border-t border-base-300">
    <p>© {{ date('Y') }} Lady's On Go · Santa Cruz de la Sierra, Bolivia</p>
    <p>Sistema de validación de identidad y documentación</p>
</footer>

</body>
</html>
