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
        Persona::firstOrCreate([
            'cedula_persona' => '18098081',
            'nombre' => 'CARLA',
            'apellido' => 'ALVAREZ',
            'telefono' => '04123728129',
            'email' => 'CARLA@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADA',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'EL ARCO'
        ]);

        Persona::firstOrCreate([
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

        Persona::firstOrCreate([
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

        Persona::firstOrCreate([
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

        Persona::firstOrCreate([
            'cedula_persona' => '15273830',
            'nombre' => 'FRANCISCO',
            'apellido' => 'GARZO',
            'telefono' => '04123838495',
            'email' => 'FRANCISCO@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'BRUZUAL',
            'direccion' => 'CALLE 15 DIAGONAL A LA PLAZA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '20938535',
            'nombre' => 'GUSTAVO',
            'apellido' => 'REINA',
            'telefono' => '04242841927',
            'email' => 'GUSTAVO@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'DOCTOR',
            'municipio' => 'BRUZUAL',
            'direccion' => 'EN FRENTE DEL LICEO'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '192038429',
            'nombre' => 'HEIMYS',
            'apellido' => 'ALVARADO',
            'telefono' => '04123728135',
            'email' => 'HEIMYS@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADA',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'EL ARCO NUEVO'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '17901234',
            'nombre' => 'HERNAN',
            'apellido' => 'SILVERA',
            'telefono' => '04143823858',
            'email' => 'HERNAN@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'CASITA ROJA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '14829421',
            'nombre' => 'HERNEL',
            'apellido' => 'MENDEZ',
            'telefono' => '04124028129',
            'email' => 'HERNEL@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADO',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'EL ARCO GRANDE'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '19321234',
            'nombre' => 'ISABEL',
            'apellido' => 'CORONEL',
            'telefono' => '04144523849',
            'email' => 'ISABEL@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'DOCTORA',
            'municipio' => 'SAN FELIPE',
            'direccion' => 'LUMAR'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '182038421',
            'nombre' => 'JACKELINE',
            'apellido' => 'SEVILLA',
            'telefono' => '04125428129',
            'email' => 'JACKELINE@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADA',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'LA PAZ'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '17121534',
            'nombre' => 'JENNIREEF',
            'apellido' => 'PAIVA',
            'telefono' => '04143878849',
            'email' => 'PAIVA@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'BRUZUAL',
            'direccion' => 'LA PALMA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '202038421',
            'nombre' => 'JESSIKA',
            'apellido' => 'HERNANDEZ',
            'telefono' => '04123728129',
            'email' => 'JESSIKA@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADA',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'CALLE ALBERTO'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '17401234',
            'nombre' => 'JUSELLY',
            'apellido' => 'SUBERO',
            'telefono' => '04143953849',
            'email' => 'JUSELLY@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'BRUZUAL',
            'direccion' => 'CALLE ROMA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '192238421',
            'nombre' => 'LEYDIS',
            'apellido' => 'SEQUERA',
            'telefono' => '04123776129',
            'email' => 'LEYDIS@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADA',
            'municipio' => 'VEROES',
            'direccion' => 'GUABINA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '19690234',
            'nombre' => 'LIDIA',
            'apellido' => 'CORDERO',
            'telefono' => '04143823999',
            'email' => 'LIDIA@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'NIRGUA',
            'direccion' => 'CASA BLANCA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '192008421',
            'nombre' => 'NORAIMA',
            'apellido' => 'MERLO',
            'telefono' => '04123722129',
            'email' => 'NORAIMA@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADA',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'LA ALDEA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '19311234',
            'nombre' => 'NULIBET',
            'apellido' => 'FIGUEROA',
            'telefono' => '04143003849',
            'email' => 'NULIBET@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'NIRGUA',
            'direccion' => 'LAS CAYENAS'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '192038111',
            'nombre' => 'OSCAR',
            'apellido' => 'OCHOA',
            'telefono' => '04163728129',
            'email' => 'OSCAR@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADO',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'ARISTIDES BASTIDAS'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '15621234',
            'nombre' => 'PEDRO',
            'apellido' => 'CONCEPCIÓN',
            'telefono' => '04243823849',
            'email' => 'PEDRO@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'NIRGUA',
            'direccion' => 'CASITA AZUL'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '192348421',
            'nombre' => 'RANMER',
            'apellido' => 'MARCHAN',
            'telefono' => '04123728187',
            'email' => 'RAMNER@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADO',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'LA ALDEITA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '17322534',
            'nombre' => 'ROBERTH',
            'apellido' => 'MUJICA',
            'telefono' => '04143822849',
            'email' => 'ROBERTH@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'NIRGUA',
            'direccion' => 'CAMINO LARGO'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '213038421',
            'nombre' => 'ROSMERY',
            'apellido' => 'SANCHEZ',
            'telefono' => '04241728129',
            'email' => 'ROSMERY@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADA',
            'municipio' => 'VEROES',
            'direccion' => 'EL ARCO'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '18121234',
            'nombre' => 'ROVER',
            'apellido' => 'MONSERRAT',
            'telefono' => '04143822749',
            'email' => 'ROVER@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'NIRGUA',
            'direccion' => 'AGUA BLANCA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '192038400',
            'nombre' => 'YANYS',
            'apellido' => 'LEON',
            'telefono' => '04263728129',
            'email' => 'YANYS@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADO',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'LA LAGUNA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '17329234',
            'nombre' => 'YENNY',
            'apellido' => 'GUEVARA',
            'telefono' => '04143823879',
            'email' => 'YENNY@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'VEROES',
            'direccion' => 'CASITA BLANCA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '192038421',
            'nombre' => 'YORFRE',
            'apellido' => 'GIANBIONI',
            'telefono' => '04126628129',
            'email' => 'YORFRE@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADA',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'EL ARCO'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '19301234',
            'nombre' => 'DAYMAR',
            'apellido' => 'RIVERO',
            'telefono' => '04143824049',
            'email' => 'DAYMAR@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'COCOROTE',
            'direccion' => 'CASITA BLANCA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '201038421',
            'nombre' => 'GUISERLY',
            'apellido' => 'LAGEA',
            'telefono' => '04123799129',
            'email' => 'GUISERLY@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADA',
            'municipio' => 'INDEPENDENCIA',
            'direccion' => 'LA CASCADA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '18911234',
            'nombre' => 'HENRY',
            'apellido' => 'MONTERREY',
            'telefono' => '04243827749',
            'email' => 'HENRY@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'NIRGUA',
            'direccion' => 'AGUA NEGRA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '192031121',
            'nombre' => 'JEIDYS',
            'apellido' => 'GARRIDO',
            'telefono' => '04123008129',
            'email' => 'JEIDYS@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADA',
            'municipio' => 'SAN FELIPE',
            'direccion' => 'EL ARCO'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '17321664',
            'nombre' => 'KIMBERLYN',
            'apellido' => 'PERNIA',
            'telefono' => '04143824449',
            'email' => 'KIMBERLYN@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'NIRGUA',
            'direccion' => 'CALLE LA PALMA NEGRA'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '22038421',
            'nombre' => 'NEYLA',
            'apellido' => 'PARRA',
            'telefono' => '04123728155',
            'email' => 'NEYLA@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'LICENCIADA',
            'municipio' => 'SUCRE',
            'direccion' => 'EL ARCO'
        ]);

        Persona::firstOrCreate([
            'cedula_persona' => '17122134',
            'nombre' => 'YULEYDI',
            'apellido' => 'SANCHEZ',
            'telefono' => '04240833849',
            'email' => 'YULEYDI@GMAIL.COM',
            'tipo_persona' => 'DOCENTE',
            'grado_inst' => 'INGENIERO',
            'municipio' => 'SUCRE',
            'direccion' => 'CASITA AMARILLA'
        ]);

    }
}
