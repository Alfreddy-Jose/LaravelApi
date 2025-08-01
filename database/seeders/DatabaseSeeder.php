<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UniversidadSeeder::class,
            SedeSeeder::class,
            PnfSeeder::class,
            RolesAndPermissionsSeeder::class,
            UsuarioSeeder::class,
            TipoLapsosSeeder::class,
            //TrimestreSeeder::class
        ]);
    }
}
