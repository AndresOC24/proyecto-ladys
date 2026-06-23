<?php

use App\Models\Role;

test('registration screen can be rendered', function () {
    $this->get('/register')->assertStatus(200);
});

test('registration step 1 stores data in session and redirects to step 2', function () {
    Role::firstOrCreate(['nombre' => 'pasajero'], ['descripcion' => 'Usuaria pasajera']);

    $response = $this->post('/register', [
        'name'            => 'María Test',
        'email'           => 'maria.test@ladys.bo',
        'password'        => 'password123',
        'password_confirmation' => 'password123',
        'telefono'        => '70000001',
        'fecha_nacimiento'=> '1995-05-15',
        'numero_carnet'   => '7654321',
        'rol'             => 'pasajero',
    ]);

    // Paso 1 guarda en sesión y redirige al paso 2 (documentos)
    $response->assertRedirect('/register/carnet');
    $this->assertGuest(); // aún no autenticada hasta terminar paso 2
});
