<?php

namespace Database\Seeders;

use App\Models\UnidadCurricular;
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
            EstadosTableSeeder::class,
            MunicipiosTableSeeder::class,
            UniversidadSeeder::class,
            TrayectoSeeder::class,
            MatriculaSeeder::class,
            TipoLapsosSeeder::class,
            PersonaSeeder::class,
            // UnidadCurricular::class,
            LapsoSeeder::class,
            SedeSeeder::class,
            EspaciosSeeder::class,
            PnfSeeder::class,
            RolesAndPermissionsSeeder::class,
            UsuarioSeeder::class,
        ]);
    }
}
