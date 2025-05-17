<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LapsoAcademico;
use App\Models\Persona;
use App\Models\Pnf;
use App\Models\Tipo_persona;
use Illuminate\Http\Request;

class TipoPersonaController extends Controller
{
    public function getFormData()
    {
        $personas = Persona::select('id', 'cedula_persona', 'nombre', 'apellido')
            ->get();
        $pnfs = Pnf::select('id', 'codigo', 'nombre')
            ->get();
        $lapsoAcademicos = LapsoAcademico::select('id', 'nombre_lapso')
        ->get();
        return response()->json([
            'personas' => $personas,
            'pnfs' => $pnfs,
            'lapsoAcademicos' => $lapsoAcademicos
        ]);
    }

    public function index()
    {
        $tipoPersonas = Tipo_persona::with(['persona:id,cedula_persona,nombre,apellido', 'pnf:id,codigo,nombre', 'lapso:id,nombre_lapso'])
            ->get();
        return response()->json($tipoPersonas);
    }
}
