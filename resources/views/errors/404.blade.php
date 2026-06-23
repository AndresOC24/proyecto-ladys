<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Página no encontrada · Lady's On Go</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-base-200 flex items-center justify-center p-6">
    <div class="text-center max-w-md">
        <div class="text-8xl font-black text-primary mb-2">404</div>
        <h1 class="text-2xl font-bold mb-2">Página no encontrada</h1>
        <p class="text-base-content/60 mb-6">La página que buscas no existe o fue movida.</p>
        <div class="flex gap-3 justify-center">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : '/' }}"
               class="btn btn-ghost">← Volver</a>
            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
               class="btn btn-primary">Ir al inicio</a>
        </div>
    </div>
</body>
</html>
