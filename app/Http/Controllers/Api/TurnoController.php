<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Turno;
use Illuminate\Http\Request; 

class TurnoController extends Controller
{
    // metodo para traer los datos de todos los turnos
    public function index() 
    {
        $turnos = Turno::select('id', 'nombre', 'inicio', 'final')->get();

        return response()->json($turnos);
    }

    // metodo para crear un turno
    public function store(Request $request)
    {
        Turno::create($request->all());

        return response()->json(['message' => 'Turno Registrado'], 200);
    }

    //metodo traer los datos de un unico turno
    public function show(Turno $turno)
    {

    }

    // metodo para editar un turno
    public function update(Request $request, Turno $turno)
    {

    }

    // metodo para eliminar un turno
    public function destroy(Turno $turno)
    {
        $turno->delete();

        return response()->json(['message' => 'Turno Eliminado'], 200);
    }
}
