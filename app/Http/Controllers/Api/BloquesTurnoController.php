<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BloquesTurno;

class BloquesTurnoController extends Controller
{
    public function index()
    {

        // Obtener todos los bloques
        // Ordenar los desde primero los de mañana luego los de tarde y luego los de noche

        $bloques = BloquesTurno::select('id', 'rango')->get();

        // Enviando datos a la api
        return response()->json($bloques);
    }
}
