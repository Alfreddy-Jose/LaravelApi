<?php

namespace Database\Seeders;

use App\Models\Pnf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PnfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pnf::firstOrCreate([
            'codigo' => '07',
            'nombre' => 'PROGRAMA NACIONAL DE FORMACIÓN EN INGENIERÍA DE SISTEMAS',
            'abreviado' => 'PNFIS',
            'abreviado_coord' => 'NFIS',
        ]);
        Pnf::firstOrCreate([
            'codigo' => '08',
            'nombre' => 'PROGRAMA NACIONAL DE FORMACIÓN EN INGENIERÍA INDUSTRIAL',
            'abreviado' => 'PNFII',
            'abreviado_coord' => 'NFII',
        ]);
        Pnf::firstOrCreate([
            'codigo' => '09',
            'nombre' => 'PROGRAMA NACIONAL DE FORMACIÓN EN INGENIERÍA CIVIL',
            'abreviado' => 'PNFIC',
            'abreviado_coord' => 'NFIC',
        ]);
        Pnf::firstOrCreate([
            'codigo' => '10',
            'nombre' => 'PROGRAMA NACIONAL DE FORMACIÓN EN INGENIERÍA ELECTRÓNICA',
            'abreviado' => 'PNFIE',
            'abreviado_coord' => 'NFIE',
        ]);
        Pnf::firstOrCreate([
            'codigo' => '11',
            'nombre' => 'PROGRAMA NACIONAL DE FORMACIÓN EN INGENIERÍA MECÁNICA',
            'abreviado' => 'PNFIM',
            'abreviado_coord' => 'NFIM',
        ]);
    }
}
