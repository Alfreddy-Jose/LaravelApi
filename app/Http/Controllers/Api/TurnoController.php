<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTurnoRequest;
use App\Models\Turno;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    // metodo para traer los datos de todos los turnos
    public function index()
    {
        $turnos = Turno::select('id', 'nombre', 'inicio', 'final', 'inicio_periodo','final_periodo')->get();

        return response()->json($turnos);
    }

    // metodo para crear un turno
    public function store(StoreTurnoRequest $request)
    {
        $turno = Turno::create($request->all());

        // Generar y guardar bloques
        $bloques = $turno->generarBloquesTurno($request->nombre, $request->inicio, $request->final, $request->inicio_periodo, $request->final_periodo);
        foreach ($bloques as $bloque) {
            $turno->bloques()->create($bloque);
        }

        return response()->json(['message' => 'Turno Registrado'], 200);
    }

    //metodo traer los datos de un unico turno
    public function show(Turno $turno) {}

    // metodo para editar un turno
    public function update(Request $request, Turno $turno) {}

    // metodo para eliminar un turno
    public function destroy(Turno $turno)
    {
        $turno->delete();

        return response()->json(['message' => 'Turno Eliminado'], 200);
    }
}
