<?php

namespace Database\Seeders;

use App\Models\Espacio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EspaciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Espacio::firstOrcreate([

            'nombre_aula' => 'E-7',
            'codigo' => '1',
            'etapa' => 'E',
            'nro_aula' => '7',
            'tipo_espacio' => 'AULA',
            'sede_id' => '1'
        ]);

        Espacio::firstOrcreate([


            'nombre_aula' => 'B-17',
            'codigo' => '21',
            'etapa' => 'B',
            'nro_aula' => '17',
            'tipo_espacio' => 'AULA',
            'sede_id' => '1'


        ]);

        Espacio::firstOrcreate([


            'nombre_aula' => 'B-18',
            'codigo' => '2',
            'etapa' => 'B',
            'nro_aula' => '18',
            'tipo_espacio' => 'AULA',
            'sede_id' => '1'


        ]);

        Espacio::firstOrcreate([


            'nombre_aula' => 'B-19',
            'codigo' => '3',
            'etapa' => 'B',
            'nro_aula' => '19',
            'tipo_espacio' => 'AULA',
            'sede_id' => '1'


        ]);

        Espacio::firstOrcreate([


            'nombre_aula' => 'B-20',
            'codigo' => '4',
            'etapa' => 'B',
            'nro_aula' => '20',
            'tipo_espacio' => 'AULA',
            'sede_id' => '1'


        ]);

        Espacio::firstOrcreate([


            'nombre_aula' => 'C-3',
            'codigo' => '5',
            'etapa' => 'C',
            'nro_aula' => '3',
            'tipo_espacio' => 'AULA',
            'sede_id' => '1'


        ]);

        Espacio::firstOrcreate([


            'nombre_aula' => 'C-4',
            'codigo' => '6',
            'etapa' => 'C',
            'nro_aula' => '4',
            'tipo_espacio' => 'AULA',
            'sede_id' => '1'


        ]);

        Espacio::firstOrcreate([


            'nombre_aula' => 'SIMÓN BOLÍVAR',
            'codigo' => '78',
            'etapa' => 'E',
            'nro_aula' => '4',
            'tipo_espacio' => 'LABORATORIO',
            'abreviado_lab' => 'SMB',
            'equipos' => '17',
            'sede_id' => '1'


        ]);

        Espacio::firstOrcreate([


            'nombre_aula' => 'HUGO CHÁVEZ',
            'codigo' => '74',
            'etapa' => 'E',
            'nro_aula' => '3',
            'tipo_espacio' => 'LABORATORIO',
            'abreviado_lab' => 'HGC',
            'equipos' => '18',
            'sede_id' => '1'


        ]);
    }
}
