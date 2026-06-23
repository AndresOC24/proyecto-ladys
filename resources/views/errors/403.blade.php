<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso denegado · Lady's On Go</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-base-200 flex items-center justify-center p-6">
    <div class="text-center max-w-md">
        <div class="text-8xl font-black text-warning mb-2">403</div>
        <h1 class="text-2xl font-bold mb-2">Acceso denegado</h1>
        <p class="text-base-content/60 mb-6">No tienes permiso para acceder a esta sección.</p>
        <div class="flex gap-3 justify-center">
            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
               class="btn btn-primary">Ir al inicio</a>
        </div>
    </div>
</body>
</html>
