<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Services\ServicioIA;
use App\Http\Controllers\RegistroController;


// Raíz: si está logueado va al dashboard, si no al login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegistroController::class, 'mostrarDatos'])->name('register');
    Route::post('register', [RegistroController::class, 'guardarDatos']);
    Route::get('register/carnet', [RegistroController::class, 'mostrarCarnet'])->name('registro.carnet');
    Route::post('register/carnet', [RegistroController::class, 'finalizar']);

    // ... resto de las rutas guest de Breeze (login, etc.) intactas
});


Route::get('/test-ia', function (ServicioIA $ia) {
    return $ia->health();
});


// Todo lo demás requiere estar autenticado
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('/registro/estado', [\App\Http\Controllers\RegistroController::class, 'estado'])
    ->name('registro.estado');

    // Solo administradores
    Route::middleware('role:administrador')->group(function () {
        Route::get('/admin/usuarias', fn() => view('admin.usuarias'))->name('admin.usuarias');
    });

    // Solo conductoras
    Route::middleware('role:conductora')->group(function () {
        Route::get('/conductora/panel', fn() => view('conductora.panel'))->name('conductora.panel');
    });

    // Pasajeras y conductoras (varios roles)
    Route::middleware('role:pasajero,conductora')->group(function () {
        Route::get('/viajes', fn() => view('viajes'))->name('viajes');
    });
});

require __DIR__.'/auth.php';