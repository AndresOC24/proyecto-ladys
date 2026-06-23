<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('usuaria puede ver su página de edición de perfil', function () {
    $user = User::factory()->pasajera()->create();

    $this->actingAs($user)
        ->get('/profile')
        ->assertOk();
});

test('usuaria puede actualizar su nombre', function () {
    $user = User::factory()->pasajera()->create(['name' => 'Nombre Viejo']);

    $this->actingAs($user)
        ->patch('/profile', [
            'name'     => 'Nombre Nuevo',
            'telefono' => '71234567',
        ])
        ->assertRedirect('/profile');

    expect($user->fresh()->name)->toBe('Nombre Nuevo');
    expect($user->fresh()->telefono)->toBe('71234567');
});

test('actualización de perfil requiere nombre', function () {
    $user = User::factory()->pasajera()->create();

    $this->actingAs($user)
        ->patch('/profile', ['name' => '', 'telefono' => ''])
        ->assertSessionHasErrors('name');
});

test('admin puede ver su página de cuenta', function () {
    $admin = User::factory()->administradora()->create();

    $this->actingAs($admin)
        ->get('/admin/mi-cuenta')
        ->assertOk()
        ->assertSee('Mi cuenta');
});

test('landing page es accesible sin autenticación', function () {
    $this->get('/')->assertRedirect('/login');
});

test('usuario autenticado es redirigido desde raíz a dashboard', function () {
    $user = User::factory()->pasajera()->create();

    $this->actingAs($user)
        ->get('/')
        ->assertRedirect('/dashboard');
});

test('admin autenticado es redirigido desde raíz a panel admin', function () {
    $admin = User::factory()->administradora()->create();

    $this->actingAs($admin)
        ->get('/')
        ->assertRedirect('/admin');
});
