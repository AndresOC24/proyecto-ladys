<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/profile')->assertOk();
});

test('profile information can be updated (name and telefono)', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->patch('/profile', [
            'name'     => 'Nombre Actualizado',
            'telefono' => '77777777',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Nombre Actualizado', $user->name);
    $this->assertSame('77777777', $user->telefono);
    // El email NO debe cambiar (read-only en nuestro sistema)
    $this->assertNotNull($user->email_verified_at);
});

test('email cannot be changed via profile update', function () {
    $user  = User::factory()->create(['email' => 'original@test.bo']);
    $email = $user->email;

    $this->actingAs($user)
        ->patch('/profile', [
            'name'     => 'Otro Nombre',
            'email'    => 'nuevo@test.bo',
            'telefono' => '',
        ])
        ->assertSessionHasNoErrors();

    // El email no debe haber cambiado
    $this->assertSame($email, $user->fresh()->email);
});
