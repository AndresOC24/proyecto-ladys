<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// ── Vistas del flujo de registro ─────────────────────────────────────────────

test('página de registro muestra el formulario de datos personales', function () {
    $this->get('/register')->assertOk()->assertSee('Crear cuenta');
});

test('usuario autenticado es redirigido fuera del registro', function () {
    $user = User::factory()->pasajera()->create();

    $this->actingAs($user)
        ->get('/register')
        ->assertRedirect();
});

test('registro paso 1 redirige a documentos', function () {
    Role::firstOrCreate(['nombre' => 'pasajero'], ['descripcion' => 'Usuaria pasajera']);

    $this->post('/register', [
        'name'                  => 'María Pérez',
        'email'                 => 'maria@test.bo',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
        'telefono'              => '70000000',
        'fecha_nacimiento'      => '1995-01-15',
        'numero_carnet'         => '1234567',
        'rol'                   => 'pasajero',
    ])->assertRedirect('/register/carnet');
});

// ── Dashboard de usuaria ──────────────────────────────────────────────────────

test('dashboard requiere autenticación', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('usuaria verificada ve su nombre en el dashboard', function () {
    $user = User::factory()->pasajera()->verificada()->create(['name' => 'Ana Prueba']);

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('Ana Prueba');
});

test('usuaria con estado analizando ve el mensaje correspondiente', function () {
    $user = User::factory()->pasajera()->create(['estado_verificacion' => 'analizando']);

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('siendo analizado');
});

test('usuaria rechazada ve la opción de reenviar documentos', function () {
    $user = User::factory()->pasajera()->create([
        'estado_verificacion' => 'rechazada',
        'resultado_analisis'  => ['motivo_rechazo' => 'Imagen borrosa'],
    ]);

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('Reenviar documentos');
});

// ── Mi perfil ─────────────────────────────────────────────────────────────────

test('mi-perfil requiere autenticación', function () {
    $this->get('/mi-perfil')->assertRedirect('/login');
});

test('usuaria puede ver su perfil', function () {
    $user = User::factory()->pasajera()->create([
        'name'          => 'Carla Prueba',
        'numero_carnet' => '9876543',
    ]);

    $this->actingAs($user)
        ->get('/mi-perfil')
        ->assertOk()
        ->assertSee('Carla Prueba')
        ->assertSee('9876543');
});

// ── Flujo de reenvío ──────────────────────────────────────────────────────────

test('reenvío solo está disponible para usuarias rechazadas', function () {
    $verificada = User::factory()->pasajera()->verificada()->create();

    $this->actingAs($verificada)
        ->get('/registro/reenviar')
        ->assertRedirect('/dashboard');
});

test('usuaria rechazada puede acceder a la página de reenvío', function () {
    $rechazada = User::factory()->pasajera()->create([
        'estado_verificacion' => 'rechazada',
        'carnet_anverso_path' => 'docs/anverso.jpg',
        'carnet_reverso_path' => 'docs/reverso.jpg',
        'selfie_path'         => 'docs/selfie.jpg',
    ]);

    $this->actingAs($rechazada)
        ->get('/registro/reenviar')
        ->assertOk();
});
