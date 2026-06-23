<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'                => fake()->name(),
            'email'               => fake()->unique()->safeEmail(),
            'email_verified_at'   => now(),
            'password'            => static::$password ??= Hash::make('password'),
            'remember_token'      => Str::random(10),
            'numero_carnet'       => fake()->numerify('#######'),
            'telefono'            => fake()->phoneNumber(),
            'activa'              => true,
            'estado_verificacion' => 'pendiente',
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function administradora(): static
    {
        return $this->state(function () {
            $rol = \App\Models\Role::firstOrCreate(
                ['nombre' => \App\Models\Role::ADMINISTRADOR],
                ['descripcion' => 'Administrador del sistema']
            );
            return ['role_id' => $rol->id, 'estado_verificacion' => 'verificada'];
        });
    }

    public function pasajera(): static
    {
        return $this->state(function () {
            $rol = \App\Models\Role::firstOrCreate(
                ['nombre' => \App\Models\Role::PASAJERO],
                ['descripcion' => 'Usuaria pasajera']
            );
            return ['role_id' => $rol->id];
        });
    }

    public function conductora(): static
    {
        return $this->state(function () {
            $rol = \App\Models\Role::firstOrCreate(
                ['nombre' => \App\Models\Role::CONDUCTORA],
                ['descripcion' => 'Usuaria conductora']
            );
            return ['role_id' => $rol->id];
        });
    }

    public function verificada(): static
    {
        return $this->state(['estado_verificacion' => 'verificada']);
    }
}
