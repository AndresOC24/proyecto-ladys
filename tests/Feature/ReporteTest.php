<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('reporte requiere autenticación de admin', function () {
    $this->get('/admin/reportes')->assertRedirect('/login');
});

test('usuaria no admin no puede acceder a reportes', function () {
    $pasajera = User::factory()->pasajera()->create();

    $this->actingAs($pasajera)
        ->get('/admin/reportes')
        ->assertForbidden();
});

test('admin puede ver la página de reportes', function () {
    $admin = User::factory()->administradora()->create();

    $this->actingAs($admin)
        ->get('/admin/reportes')
        ->assertOk()
        ->assertSee('Reporte');
});

test('admin puede filtrar reportes por rango de fechas', function () {
    $admin = User::factory()->administradora()->create();

    $this->actingAs($admin)
        ->get('/admin/reportes?desde=2025-01-01&hasta=2025-12-31')
        ->assertOk();
});

test('admin puede exportar reporte en PDF', function () {
    $admin = User::factory()->administradora()->create();

    $response = $this->actingAs($admin)
        ->get('/admin/reportes/exportar/pdf?desde=2025-01-01&hasta=2025-12-31');

    $response->assertOk();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
});

test('admin puede exportar reporte en Excel', function () {
    $admin = User::factory()->administradora()->create();

    $response = $this->actingAs($admin)
        ->get('/admin/reportes/exportar/excel?desde=2025-01-01&hasta=2025-12-31');

    $response->assertOk();
    expect($response->headers->get('content-type'))->toContain('ms-excel');
});

test('formato de exportación inválido devuelve 404', function () {
    $admin = User::factory()->administradora()->create();

    $this->actingAs($admin)
        ->get('/admin/reportes/exportar/xml')
        ->assertNotFound();
});
