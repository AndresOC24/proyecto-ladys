<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// ── Autenticación ────────────────────────────────────────────────────────────

test('panel admin requiere autenticación', function () {
    $this->get('/admin')->assertRedirect('/login');
});

test('usuaria sin rol admin no puede acceder al panel', function () {
    $pasajera = User::factory()->pasajera()->create();

    $this->actingAs($pasajera)
        ->get('/admin')
        ->assertForbidden();
});

test('administradora puede acceder al panel', function () {
    $admin = User::factory()->administradora()->create();

    $this->actingAs($admin)
        ->get('/admin')
        ->assertOk();
});

// ── Listado de usuarias ──────────────────────────────────────────────────────

test('admin ve el listado de usuarias', function () {
    $admin    = User::factory()->administradora()->create();
    $pasajera = User::factory()->pasajera()->create(['name' => 'Ana López']);

    $this->actingAs($admin)
        ->get('/admin/usuarias')
        ->assertOk()
        ->assertSee('Ana López');
});

test('admin puede filtrar usuarias por estado', function () {
    $admin      = User::factory()->administradora()->create();
    $verificada = User::factory()->pasajera()->verificada()->create(['name' => 'Verificada Test']);
    $rechazada  = User::factory()->pasajera()->create([
        'name'                => 'Rechazada Test',
        'estado_verificacion' => 'rechazada',
    ]);

    $response = $this->actingAs($admin)->get('/admin/usuarias?estado=verificada');

    $response->assertOk()
             ->assertSee('Verificada Test')
             ->assertDontSee('Rechazada Test');
});

// ── Revisión administrativa ──────────────────────────────────────────────────

test('admin puede aprobar una usuaria', function () {
    $admin    = User::factory()->administradora()->create();
    $pasajera = User::factory()->pasajera()->create(['estado_verificacion' => 'pendiente']);

    $this->actingAs($admin)
        ->post("/admin/usuarias/{$pasajera->id}/aprobar")
        ->assertRedirect();

    expect($pasajera->fresh()->estado_verificacion)->toBe('verificada');
});

test('admin puede rechazar una usuaria con motivo', function () {
    $admin    = User::factory()->administradora()->create();
    $pasajera = User::factory()->pasajera()->create(['estado_verificacion' => 'pendiente']);

    $this->actingAs($admin)
        ->post("/admin/usuarias/{$pasajera->id}/rechazar", ['motivo' => 'Imagen borrosa'])
        ->assertRedirect();

    expect($pasajera->fresh()->estado_verificacion)->toBe('rechazada');
});

test('rechazo sin motivo falla con error de validación', function () {
    $admin    = User::factory()->administradora()->create();
    $pasajera = User::factory()->pasajera()->create();

    $this->actingAs($admin)
        ->post("/admin/usuarias/{$pasajera->id}/rechazar", ['motivo' => ''])
        ->assertSessionHasErrors('motivo');
});

// ── Bandeja de revisión ──────────────────────────────────────────────────────

test('bandeja de revisión muestra solo casos pendientes', function () {
    $admin    = User::factory()->administradora()->create();
    $pendiente = User::factory()->pasajera()->create([
        'name'                => 'Pendiente Test',
        'estado_verificacion' => 'pendiente',
    ]);
    $verificada = User::factory()->pasajera()->verificada()->create(['name' => 'Verificada Test']);

    $this->actingAs($admin)
        ->get('/admin/revision')
        ->assertOk()
        ->assertSee('Pendiente Test')
        ->assertDontSee('Verificada Test');
});

// ── Bitácora ─────────────────────────────────────────────────────────────────

test('admin puede acceder a la bitácora', function () {
    $admin = User::factory()->administradora()->create();

    $this->actingAs($admin)
        ->get('/admin/bitacora')
        ->assertOk();
});

// ── Parámetros de control ────────────────────────────────────────────────────

test('admin puede ver la lista de parámetros', function () {
    $admin = User::factory()->administradora()->create();

    $this->actingAs($admin)
        ->get('/admin/parametros')
        ->assertOk();
});

test('admin puede crear un parámetro de control', function () {
    $admin = User::factory()->administradora()->create();

    $this->actingAs($admin)
        ->post('/admin/parametros/crear', [
            'tipo_documento'   => 'cedula',
            'nombre_parametro' => 'test_param',
            'categoria'        => 'campo_requerido',
            'es_bloqueante'    => 1,
        ])
        ->assertRedirect('/admin/parametros');

    $this->assertDatabaseHas('parametros_control', ['nombre_parametro' => 'test_param']);
});

// ── Gestión de administradoras ───────────────────────────────────────────────

test('admin puede crear una nueva administradora', function () {
    $admin = User::factory()->administradora()->create();

    $this->actingAs($admin)
        ->post('/admin/administradoras', [
            'name'                  => 'Nueva Admin',
            'email'                 => 'nueva@admin.bo',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertRedirect('/admin/administradoras');

    $this->assertDatabaseHas('users', ['email' => 'nueva@admin.bo']);
});
