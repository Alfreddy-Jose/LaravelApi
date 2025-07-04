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
        Trimestre::create(['nombre' => 'I']);
        Trimestre::create(['nombre' => 'II']);
        Trimestre::create(['nombre' => 'III']);
    }
}
