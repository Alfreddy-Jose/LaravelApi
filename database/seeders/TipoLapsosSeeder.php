<?php

namespace Database\Seeders;

use App\Models\TipoLapso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoLapsosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoLapso::create([
            'id' => '4',
            'nombre' => 'REGULAR',
        ]);
        TipoLapso::create([
            'id' => '5',
            'nombre' => 'INTENSIVO',
        ]);
        TipoLapso::create([
            'id' => '7',
            'nombre' => 'PIU',
        ]);
    }
}
