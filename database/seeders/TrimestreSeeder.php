<?php

namespace Database\Seeders;

use App\Models\Trimestre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrimestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trimestre::firstOrCreate(['nombre' => 'I']);
        Trimestre::firstOrCreate(['nombre' => 'II']);
        Trimestre::firstOrCreate(['nombre' => 'III']);
        Trimestre::firstOrCreate(['nombre' => 'IV']);
        Trimestre::firstOrCreate(['nombre' => 'V']);
        Trimestre::firstOrCreate(['nombre' => 'VI']);
        Trimestre::firstOrCreate(['nombre' => 'VII']);
    }
}
