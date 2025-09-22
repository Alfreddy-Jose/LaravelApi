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
        UnidadCurricular::firstOrcreate([
            'nombre' => 'MATEMATICA I',
            'descripcion' => '',
            'unidad_credito' => '9',
            'hora_teorica' => '12',
            'hora_practica' => '11',
            'hora_total_est' => '23',
            'periodo' => 'ANUAL',
        ]);

        UnidadCurricular::firstOrcreate([
            'nombre' => 'ELECTIVA I',
            'descripcion' => '',
            'unidad_credito' => '9',
            'hora_teorica' => '12',
            'hora_practica' => '11',
            'hora_total_est' => '23',
            'periodo' => 'ANUAL',
        ]);

        UnidadCurricular::firstOrcreate([
            'nombre' => 'PROYECTO I',
            'descripcion' => '',
            'unidad_credito' => '9',
            'hora_teorica' => '12',
            'hora_practica' => '11',
            'hora_total_est' => '23',
            'periodo' => 'ANUAL',
        ]);

        UnidadCurricular::firstOrcreate([
            'nombre' => 'ALGORITMICA I',
            'descripcion' => '',
            'unidad_credito' => '9',
            'hora_teorica' => '12',
            'hora_practica' => '11',
            'hora_total_est' => '23',
            'periodo' => 'ANUAL',
        ]);

        UnidadCurricular::firstOrcreate([
            'nombre' => 'MATEMATICA II',
            'descripcion' => '',
            'unidad_credito' => '10',
            'hora_teorica' => '12',
            'hora_practica' => '11',
            'hora_total_est' => '23',
            'periodo' => 'SEMESTRAL',
        ]);

        UnidadCurricular::firstOrcreate([
            'nombre' => 'ELECTIVA II',
            'descripcion' => '',
            'unidad_credito' => '8',
            'hora_teorica' => '11',
            'hora_practica' => '11',
            'hora_total_est' => '22',
            'periodo' => 'ANUAL',
        ]);


        UnidadCurricular::firstOrcreate([
            'nombre' => 'PROYECTO II',
            'descripcion' => '',
            'unidad_credito' => '11',
            'hora_teorica' => '12',
            'hora_practica' => '11',
            'hora_total_est' => '23',
            'periodo' => 'ANUAL',
        ]);

        UnidadCurricular::firstOrcreate([
            'nombre' => 'BASE DE DATOS',
            'descripcion' => '',
            'unidad_credito' => '9',
            'hora_teorica' => '12',
            'hora_practica' => '11',
            'hora_total_est' => '23',
            'periodo' => 'ANUAL',
        ]);

        UnidadCurricular::firstOrcreate([
            'nombre' => 'MATEMATICA III',
            'descripcion' => '',
            'unidad_credito' => '9',
            'hora_teorica' => '12',
            'hora_practica' => '11',
            'hora_total_est' => '23',
            'periodo' => 'SEMESTRAL',
        ]);
    }
}
