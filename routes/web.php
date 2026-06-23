<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Services\ServicioIA;
use App\Http\Controllers\RegistroController;


// Raíz: si está logueado va al dashboard, si no al login
Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }
    return auth()->user()->esAdministrador()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegistroController::class, 'mostrarDatos'])->name('register');
    Route::post('register', [RegistroController::class, 'guardarDatos']);

    Route::get('register/carnet', [RegistroController::class, 'mostrarCarnet'])->name('registro.carnet');
    Route::post('register/carnet', [RegistroController::class, 'guardarCarnet']);

    Route::get('register/selfie', [RegistroController::class, 'mostrarSelfie'])->name('registro.selfie');
    Route::post('register/selfie', [RegistroController::class, 'guardarSelfie']);

    Route::get('register/licencia', [RegistroController::class, 'mostrarLicencia'])->name('registro.licencia');
    Route::post('register/licencia', [RegistroController::class, 'guardarLicencia']);

    Route::get('register/vehiculo', [RegistroController::class, 'mostrarVehiculo'])->name('registro.vehiculo');
    Route::post('register/vehiculo', [RegistroController::class, 'guardarVehiculo']);
});


Route::get('/test-ia', function (ServicioIA $ia) {
    return $ia->health();
});


// Todo lo demás requiere estar autenticado
Route::middleware(['auth'])->group(function () {
    // Las administradoras siempre van a su panel; el resto ve su dashboard.
    Route::get('/dashboard', function () {
        return auth()->user()->esAdministrador()
            ? redirect()->route('admin.dashboard')
            : view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/registro/estado', [\App\Http\Controllers\RegistroController::class, 'estado'])
        ->name('registro.estado');

    Route::get('/mi-perfil', function () {
        $user = auth()->user();
        if ($user->esAdministrador()) {
            return redirect()->route('admin.dashboard');
        }
        return view('mi-perfil', ['user' => $user]);
    })->name('mi-perfil');

    Route::get('/registro/reenviar', [\App\Http\Controllers\RegistroController::class, 'mostrarReenvio'])
        ->name('registro.reenviar');
    Route::post('/registro/reenviar', [\App\Http\Controllers\RegistroController::class, 'guardarReenvio']);

    // Solo administradores
Route::middleware('role:administrador')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/usuarias', [\App\Http\Controllers\AdminController::class, 'usuarias'])->name('usuarias');
    Route::get('/usuarias/exportar-csv', [\App\Http\Controllers\AdminController::class, 'exportarCsv'])->name('usuarias.csv');
    Route::get('/usuarias/{usuaria}/imprimir', [\App\Http\Controllers\AdminController::class, 'imprimir'])->name('usuaria.imprimir');
    Route::get('/usuarias/{usuaria}', [\App\Http\Controllers\AdminController::class, 'ver'])->name('usuaria.ver');
    Route::post('/usuarias/{usuaria}/aprobar', [\App\Http\Controllers\AdminController::class, 'aprobar'])->name('usuaria.aprobar');
    Route::post('/usuarias/{usuaria}/rechazar', [\App\Http\Controllers\AdminController::class, 'rechazar'])->name('usuaria.rechazar');
    Route::post('/usuarias/{usuaria}/reanalizar', [\App\Http\Controllers\AdminController::class, 'reanalizar'])->name('usuaria.reanalizar');
    Route::post('/usuarias/{usuaria}/desactivar', [\App\Http\Controllers\AdminController::class, 'desactivar'])->name('usuaria.desactivar');
    Route::post('/usuarias/{usuaria}/reactivar', [\App\Http\Controllers\AdminController::class, 'reactivar'])->name('usuaria.reactivar');
    Route::delete('/usuarias/{usuaria}', [\App\Http\Controllers\AdminController::class, 'eliminar'])->name('usuaria.eliminar');
    Route::post('/usuarias/{usuaria}/rol', [\App\Http\Controllers\AdminController::class, 'asignarRol'])->name('usuaria.rol');
    Route::get('/usuarias/{usuaria}/imagen/{tipo}', [\App\Http\Controllers\AdminController::class, 'imagen'])->name('usuaria.imagen');

    // Generación de reportes
    Route::get('/reportes', [\App\Http\Controllers\ReporteController::class, 'index'])->name('reportes');
    Route::get('/reportes/exportar/{formato}', [\App\Http\Controllers\ReporteController::class, 'exportar'])->name('reportes.exportar');

    // Bitácora de auditoría
    Route::get('/bitacora', [\App\Http\Controllers\AdminController::class, 'bitacora'])->name('bitacora');

    // Bandeja de revisión
    Route::get('/revision', [\App\Http\Controllers\AdminController::class, 'revision'])->name('revision');

    // Parámetros de control — rutas fijas ANTES que las de modelo {parametro}
    Route::get('/parametros', [\App\Http\Controllers\AdminController::class, 'parametros'])->name('parametros');
    Route::get('/parametros/crear', [\App\Http\Controllers\AdminController::class, 'crearParametroForm'])->name('parametros.crear');
    Route::post('/parametros/crear', [\App\Http\Controllers\AdminController::class, 'guardarParametro'])->name('parametros.guardar');
    Route::get('/parametros/{parametro}/editar', [\App\Http\Controllers\AdminController::class, 'editarParametro'])->name('parametros.editar');
    Route::post('/parametros/{parametro}/toggle', [\App\Http\Controllers\AdminController::class, 'toggleParametro'])->name('parametros.toggle');
    Route::patch('/parametros/{parametro}', [\App\Http\Controllers\AdminController::class, 'actualizarParametro'])->name('parametros.actualizar');
    Route::delete('/parametros/{parametro}', [\App\Http\Controllers\AdminController::class, 'eliminarParametro'])->name('parametros.eliminar');

    // Gestión de administradoras
    Route::get('/administradoras', [\App\Http\Controllers\AdminController::class, 'administradoras'])->name('administradoras');
    Route::get('/administradoras/crear', [\App\Http\Controllers\AdminController::class, 'crearAdminForm'])->name('administradoras.crear');
    Route::post('/administradoras', [\App\Http\Controllers\AdminController::class, 'guardarAdmin'])->name('administradoras.guardar');

    // Cuenta propia del admin
    Route::get('/mi-cuenta', fn () => view('admin.mi-cuenta'))->name('mi-cuenta');
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