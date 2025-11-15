<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BloquesTurno;

class BloquesTurnoController extends Controller
{
    public function index()
    {

        $bloques = BloquesTurno::ordenados()->get();
        // Enviando datos a la api
        return response()->json($bloques);
    }
}
