<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::firstOrCreate(
            ['nombre' => Role::ADMINISTRADOR],
            ['descripcion' => 'Administrador del sistema']
        );

        Role::firstOrCreate(
            ['nombre' => Role::PASAJERO],
            ['descripcion' => 'Usuaria pasajera']
        );

        Role::firstOrCreate(
            ['nombre' => Role::CONDUCTORA],
            ['descripcion' => 'Usuaria conductora']
        );

        // Asignar rol admin a la usuaria existente
        User::where('email', 'scze.biancasthefania.aguilar.du@unifranz.edu.bo')
            ->update(['role_id' => $admin->id]);
    }
}