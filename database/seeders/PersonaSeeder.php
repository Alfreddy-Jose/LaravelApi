<?php

namespace Database\Seeders;

use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Persona::firstOrcreate([
            'cedula_persona' => '192038421',
            'nombre' => 'CARLA',
            'apellido' => 'ALVAREZ',
            'telefono' => '04123728129',
            'email' => 'CARLA@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADA',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'EL ARCO'
        ]);

        Persona::firstOrcreate([
            'cedula_persona' => '17321234',
            'nombre' => 'CARLOS',
            'apellido' => 'ESTEPHAN',
            'telefono' => '04143823849',
            'email' => 'CARLOS@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'NIRGUA',
            'direccion' => 'CASITA BLANCA'
        ]);

        Persona::firstOrcreate([
            'cedula_persona' => '20938532',
            'nombre' => 'DORA',
            'apellido' => 'MENDOZA',
            'telefono' => '04242841923',
            'email' => 'DORA@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'DOCTORA',
            'municipio' => 'YARITAGUA',
            'direccion' => 'EN FRENTE DEL ESCUELA'
        ]);

        Persona::firstOrcreate([
            'cedula_persona' => '15273829',
            'nombre' => 'TOM',
            'apellido' => 'ZAMBRANO',
            'telefono' => '04123838493',
            'email' => 'TOM@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'PEÑA',
            'direccion' => 'CALLE 13 DIAGONAL AL ZAMÁN'
        ]);
    }
}
