<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['id_estado' => 1, 'estado' => 'Amazonas', 'iso_3166' => 'VE-X'],
            ['id_estado' => 2, 'estado' => 'Anzoátegui', 'iso_3166' => 'VE-B'],
            ['id_estado' => 3, 'estado' => 'Apure', 'iso_3166' => 'VE-C'],
            ['id_estado' => 4, 'estado' => 'Aragua', 'iso_3166' => 'VE-D'],
            ['id_estado' => 5, 'estado' => 'Barinas', 'iso_3166' => 'VE-E'],
            ['id_estado' => 6, 'estado' => 'Bolívar', 'iso_3166' => 'VE-F'],
            ['id_estado' => 7, 'estado' => 'Carabobo', 'iso_3166' => 'VE-G'],
            ['id_estado' => 8, 'estado' => 'Cojedes', 'iso_3166' => 'VE-H'],
            ['id_estado' => 9, 'estado' => 'Delta Amacuro', 'iso_3166' => 'VE-Y'],
            ['id_estado' => 10, 'estado' => 'Falcón', 'iso_3166' => 'VE-I'],
            ['id_estado' => 11, 'estado' => 'Guárico', 'iso_3166' => 'VE-J'],
            ['id_estado' => 12, 'estado' => 'Lara', 'iso_3166' => 'VE-K'],
            ['id_estado' => 13, 'estado' => 'Mérida', 'iso_3166' => 'VE-L'],
            ['id_estado' => 14, 'estado' => 'Miranda', 'iso_3166' => 'VE-M'],
            ['id_estado' => 15, 'estado' => 'Monagas', 'iso_3166' => 'VE-N'],
            ['id_estado' => 16, 'estado' => 'Nueva Esparta', 'iso_3166' => 'VE-O'],
            ['id_estado' => 17, 'estado' => 'Portuguesa', 'iso_3166' => 'VE-P'],
            ['id_estado' => 18, 'estado' => 'Sucre', 'iso_3166' => 'VE-R'],
            ['id_estado' => 19, 'estado' => 'Táchira', 'iso_3166' => 'VE-S'],
            ['id_estado' => 20, 'estado' => 'Trujillo', 'iso_3166' => 'VE-T'],
            ['id_estado' => 21, 'estado' => 'La Guaira', 'iso_3166' => 'VE-W'],
            ['id_estado' => 22, 'estado' => 'Yaracuy', 'iso_3166' => 'VE-U'],
            ['id_estado' => 23, 'estado' => 'Zulia', 'iso_3166' => 'VE-V'],
            ['id_estado' => 24, 'estado' => 'Distrito Capital', 'iso_3166' => 'VE-A'],
            ['id_estado' => 25, 'estado' => 'Dependencias Federales', 'iso_3166' => 'VE-Z'],
        ];
        
        DB::table('estados')->insert($estados);
    }
}
