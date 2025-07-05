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
        // Usuario Administrador
        $administrador = User::firstOrCreate(
            ['email' => 'administrador@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('12345678'),
            ]
        );
        $administrador->assignRole('ADMINISTRADOR');

        // Usuario Asistente
        $asistente = User::firstOrCreate(
            ['email' => 'romulo@gmail.com'],
            [
                'name' => 'Romulo',
                'password' => Hash::make('romulo123'),
            ]
        );
        $asistente->assignRole('ASISTENTE');
    }
}
