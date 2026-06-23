<?php

use App\Models\User;
use Illuminate\Support\Facades\Password;

test('reset password link screen can be rendered', function () {
    $this->get('/forgot-password')->assertStatus(200);
});

test('reset password link can be requested for existing user', function () {
    $user = User::factory()->create();

    $response = $this->post('/forgot-password', ['email' => $user->email]);

    // Nuestro controller no envía email — genera el token y devuelve el link en sesión
    $response->assertRedirect();
    $response->assertSessionHas('status');
});

test('forgot password with unknown email returns generic status', function () {
    $response = $this->post('/forgot-password', ['email' => 'no-existe@test.bo']);

    $response->assertRedirect();
    $response->assertSessionHas('status');
});

test('reset password screen can be rendered with valid token', function () {
    $user  = User::factory()->create();
    $token = Password::broker()->createToken($user);

    $this->get('/reset-password/' . $token)->assertStatus(200);
});

test('password can be reset with valid token', function () {
    $user  = User::factory()->create();
    $token = Password::broker()->createToken($user);

    $response = $this->post('/reset-password', [
        'token'                 => $token,
        'email'                 => $user->email,
        'password'              => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertSessionHasNoErrors()->assertRedirect(route('login'));
});
