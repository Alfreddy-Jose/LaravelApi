<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  
        // Creando Usuario Administrador
        $administrador = User::create([
            'name' => 'Administrador',
            'email' => 'administrador@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        // Asignando Rol de Administrador
        $administrador->assignRole('ADMINISTRADOR');

        // Creando Usuario Asistente
        $asistente = User::create([
            'name' => 'Romulo',
            'email' => 'romulo@gmail.com',
            'password' => Hash::make('romulo123'),
        ]);
        // Asignando Rol de Asistente
        $asistente->assignRole('ASISTENTE');
    }
}
