<?php

namespace Database\Seeders;

use App\Models\UnidadCurricular;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnidadCurricularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidad = UnidadCurricular::firstOrCreate([
            'nombre' => 'MATEMÁTICA I',
            'periodo' => 'ANUAL'
        ], [
            'descripcion' => '',
            'unidad_credito' => 9,
            'hora_teorica' => 5,
            'hora_practica' => null,
            'hora_total_est' => 5,
        ]);

        $unidad->trimestres()->sync([1, 2, 3]);

        $unidad2 = UnidadCurricular::firstOrCreate([
            'nombre' => 'ELECTIVA I',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '3',
            'hora_practica' => null,
            'hora_total_est' => '3',
            'periodo' => 'ANUAL',
        ]);

        $unidad2->trimestres()->sync([1, 2, 3]);

        $unidad3 = UnidadCurricular::firstOrCreate([
            'nombre' => 'PROYECTO SOCIOTECNOLOGICO I',
            'descripcion' => '',
            'unidad_credito' => '9',
            'hora_teorica' => '6',
            'hora_practica' => null,
            'hora_total_est' => '6',
            'periodo' => 'ANUAL',
        ]);

        $unidad3->trimestres()->sync([1, 2, 3]);

        $unidad4 = UnidadCurricular::firstOrCreate([
            'nombre' => 'ALGORITMICA Y PROGRAMACION I',
            'descripcion' => '',
            'unidad_credito' => '12',
            'hora_teorica' => '6',
            'hora_practica' => '3',
            'hora_total_est' => '9',
            'periodo' => 'ANUAL',
        ]);

        $unidad4->trimestres()->sync([1, 2, 3]);

        $unidad5 = UnidadCurricular::firstOrCreate([
            'nombre' => 'ARQUITECTURA DEL COMPUTADOR',
            'descripcion' => '',
            'unidad_credito' => '9',
            'hora_teorica' => '5',
            'hora_practica' => '3',
            'hora_total_est' => '8',
            'periodo' => 'ANUAL',
        ]);

        $unidad5->trimestres()->sync([1, 2, 3]);

        $unidad6 = UnidadCurricular::firstOrCreate([
            'nombre' => 'FORMACIÓN CRITICA I',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '2',
            'hora_practica' => null,
            'hora_total_est' => '2',
            'periodo' => 'ANUAL',
        ]);

        $unidad6->trimestres()->sync([1, 2, 3]);

        $unidad7 = UnidadCurricular::firstOrCreate([
            'nombre' => 'IDIOMA I',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '2',
            'hora_practica' => null,
            'hora_total_est' => '2',
            'periodo' => 'ANUAL',
        ]);

        $unidad7->trimestres()->sync([1, 2, 3]);

        $unidad8 = UnidadCurricular::firstOrCreate([
            'nombre' => 'UNIDAD ACREDITABLE I',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '2',
            'hora_practica' => null,
            'hora_total_est' => '2',
            'periodo' => 'ANUAL',
        ]);

        $unidad8->trimestres()->sync([1, 2, 3]);

        $unidad9 = UnidadCurricular::firstOrCreate([
            'nombre' => 'MATEMÁTICA II',
            'descripcion' => '',
            'unidad_credito' => '6',
            'hora_teorica' => '5',
            'hora_practica' => null,
            'hora_total_est' => '5',
            'periodo' => 'SEMESTRAL',
        ]);

        $unidad9->trimestres()->sync([4, 5]);

        $unidad10 = UnidadCurricular::firstOrCreate([
            'nombre' => 'ELECTIVA II',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '3',
            'hora_practica' => null,
            'hora_total_est' => '3',
            'periodo' => 'TRIMESTRAL',
        ]);

        $unidad10->trimestres()->sync([6]);

        $unidad11 = UnidadCurricular::firstOrCreate([
            'nombre' => 'PROYECTO SOCIOTECNOLOGICO II',
            'descripcion' => '',
            'unidad_credito' => '9',
            'hora_teorica' => '6',
            'hora_practica' => null,
            'hora_total_est' => '6',
            'periodo' => 'ANUAL',
        ]);

        $unidad11->trimestres()->sync([4, 5, 6]);

        $unidad12 = UnidadCurricular::firstOrCreate([
            'nombre' => 'BASE DE DATOS',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '5',
            'hora_practica' => null,
            'hora_total_est' => '5',
            'periodo' => 'TRIMESTRAL',
        ]);

        $unidad12->trimestres()->sync([5]);

        $unidad13 = UnidadCurricular::firstOrCreate([
            'nombre' => 'REDES DEL COMPUTADOR',
            'descripcion' => '',
            'unidad_credito' => '6',
            'hora_teorica' => '5',
            'hora_practica' => '3',
            'hora_total_est' => '8',
            'periodo' => 'SEMESTRAL',
        ]);

        $unidad13->trimestres()->sync([4, 5]);

        $unidad14 = UnidadCurricular::firstOrCreate([
            'nombre' => 'FORMACIÓN CRITICA II',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '2',
            'hora_practica' => null,
            'hora_total_est' => '2',
            'periodo' => 'ANUAL',
        ]);

        $unidad14->trimestres()->sync([4, 5, 6]);

        $unidad15 = UnidadCurricular::firstOrCreate([
            'nombre' => 'PARADIGMA DE PROGRAMACION II',
            'descripcion' => '',
            'unidad_credito' => '12',
            'hora_teorica' => '6',
            'hora_practica' => '3',
            'hora_total_est' => '9',
            'periodo' => 'ANUAL',
        ]);

        $unidad15->trimestres()->sync([4, 5, 6]);

        $unidad16 = UnidadCurricular::firstOrCreate([
            'nombre' => 'INGENIERIA DEL SOFTWARE I',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '5',
            'hora_practica' => null,
            'hora_total_est' => '5',
            'periodo' => 'TRIMESTRAL',
        ]);

        $unidad16->trimestres()->sync([4]);

        $unidad17 = UnidadCurricular::firstOrCreate([
            'nombre' => 'UNIDAD ACREDITABLE II',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '2',
            'hora_practica' => null,
            'hora_total_est' => '2',
            'periodo' => 'ANUAL',
        ]);

        $unidad17->trimestres()->sync([4, 5, 6]);

        $unidad18 = UnidadCurricular::firstOrCreate([
            'nombre' => 'MATEMÁTICA APLICADA',
            'descripcion' => '',
            'unidad_credito' => '6',
            'hora_teorica' => '5',
            'hora_practica' => null,
            'hora_total_est' => '5',
            'periodo' => 'SEMESTRAL',
        ]);

        $unidad18->trimestres()->sync([7, 8]);

        $unidad19 = UnidadCurricular::firstOrCreate([
            'nombre' => 'SISTEMA OPERATIVO',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '5',
            'hora_practica' => null,
            'hora_total_est' => '5',
            'periodo' => 'TRIMESTRAL',
        ]);

        $unidad19->trimestres()->sync([7]);

        $unidad20 = UnidadCurricular::firstOrCreate([
            'nombre' => 'FORMACIÓN CRITICA III',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '2',
            'hora_practica' => null,
            'hora_total_est' => '2',
            'periodo' => 'ANUAL',
        ]);

        $unidad20->trimestres()->sync([7, 8, 9]);

        $unidad21 = UnidadCurricular::firstOrCreate([
            'nombre' => 'PROYECTO SOCIOTECNOLOGICO III',
            'descripcion' => '',
            'unidad_credito' => '9',
            'hora_teorica' => '6',
            'hora_practica' => null,
            'hora_total_est' => '6',
            'periodo' => 'ANUAL',
        ]);

        $unidad21->trimestres()->sync([7, 8, 9]);

        $unidad22 = UnidadCurricular::firstOrCreate([
            'nombre' => 'INGENIERIA DEL SOFTWARE II',
            'descripcion' => '',
            'unidad_credito' => '9',
            'hora_teorica' => '5',
            'hora_practica' => null,
            'hora_total_est' => '5',
            'periodo' => 'ANUAL',
        ]);

        $unidad22->trimestres()->sync([7, 8, 9]);

        $unidad23 = UnidadCurricular::firstOrCreate([
            'nombre' => 'ELECTIVA III',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '6',
            'hora_practica' => null,
            'hora_total_est' => '6',
            'periodo' => 'ANUAL',
        ]);

        $unidad23->trimestres()->sync([7, 8, 9]);

        $unidad24 = UnidadCurricular::firstOrCreate([
            'nombre' => 'INVESTIGACIÓN DE OPERACIONES',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '5',
            'hora_practica' => null,
            'hora_total_est' => '5',
            'periodo' => 'TRIMESTRAL',
        ]);

        $unidad24->trimestres()->sync([9]);

        $unidad25 = UnidadCurricular::firstOrCreate([
            'nombre' => 'MODELADO DE BASE DE DATOS',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '5',
            'hora_practica' => null,
            'hora_total_est' => '5',
            'periodo' => 'TRIMESTRAL',
        ]);

        $unidad25->trimestres()->sync([8]);

        $unidad26 = UnidadCurricular::firstOrCreate([
            'nombre' => 'UNIDAD ACREDITABLE III',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '2',
            'hora_practica' => null,
            'hora_total_est' => '2',
            'periodo' => 'ANUAL',
        ]);

        $unidad26->trimestres()->sync([7, 8, 9]);

        $unidad27 = UnidadCurricular::firstOrCreate([
            'nombre' => 'FORMACIÓN CRITICA IV',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '2',
            'hora_practica' => null,
            'hora_total_est' => '2',
            'periodo' => 'ANUAL',
        ]);

        $unidad27->trimestres()->sync([10, 11, 12]);

        $unidad28 = UnidadCurricular::firstOrCreate([
            'nombre' => 'PROYECTO SOCIOTECNOLOGICO IV',
            'descripcion' => '',
            'unidad_credito' => '9',
            'hora_teorica' => '6',
            'hora_practica' => null,
            'hora_total_est' => '6',
            'periodo' => 'ANUAL',
        ]);

        $unidad28->trimestres()->sync([10, 11, 12]);

        $unidad29 = UnidadCurricular::firstOrCreate([
            'nombre' => 'SEGURIDAD INFORMATICA',
            'descripcion' => '',
            'unidad_credito' => '4',
            'hora_teorica' => '6',
            'hora_practica' => null,
            'hora_total_est' => '6',
            'periodo' => 'TRIMESTRAL',
        ]);

        $unidad29->trimestres()->sync([11]);

        $unidad30 = UnidadCurricular::firstOrCreate([
            'nombre' => 'ADMINISTRACIÓN DE BASE DE DATOS',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '5',
            'hora_practica' => null,
            'hora_total_est' => '5',
            'periodo' => 'TRIMESTRAL',
        ]);

        $unidad30->trimestres()->sync([10]);

        $unidad31 = UnidadCurricular::firstOrCreate([
            'nombre' => 'IDIOMA II',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '2',
            'hora_practica' => null,
            'hora_total_est' => '2',
            'periodo' => 'ANUAL',
        ]);

        $unidad31->trimestres()->sync([10, 11, 12]);

        $unidad32 = UnidadCurricular::firstOrCreate([
            'nombre' => 'REDES AVANZADAS',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '5',
            'hora_practica' => null,
            'hora_total_est' => '5',
            'periodo' => 'TRIMESTRAL',
        ]);

        $unidad32->trimestres()->sync([11]);

        $unidad33 = UnidadCurricular::firstOrCreate([
            'nombre' => 'GESTION DE PROYECTO DE INFORMATICA',
            'descripcion' => '',
            'unidad_credito' => '4',
            'hora_teorica' => '6',
            'hora_practica' => null,
            'hora_total_est' => '6',
            'periodo' => 'TRIMESTREL',
        ]);

        $unidad33->trimestres()->sync([10]);

        $unidad34 = UnidadCurricular::firstOrCreate([
            'nombre' => 'AUDITORIA INFORMATICA',
            'descripcion' => '',
            'unidad_credito' => '4',
            'hora_teorica' => '6',
            'hora_practica' => null,
            'hora_total_est' => '6',
            'periodo' => 'TRIMESTREL',
        ]);

        $unidad34->trimestres()->sync([12]);

        $unidad35 = UnidadCurricular::firstOrCreate([
            'nombre' => 'ELECTIVA IV',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '6',
            'hora_practica' => null,
            'hora_total_est' => '6',
            'periodo' => 'ANUAL',
        ]);

        $unidad35->trimestres()->sync([10, 11, 12]);

        $unidad36 = UnidadCurricular::firstOrCreate([
            'nombre' => 'UNIDAD ACREDITABLE IV',
            'descripcion' => '',
            'unidad_credito' => '3',
            'hora_teorica' => '2',
            'hora_practica' => null,
            'hora_total_est' => '2',
            'periodo' => 'ANUAL',
        ]);

        $unidad36->trimestres()->sync([10, 11, 12]);

    }
}
