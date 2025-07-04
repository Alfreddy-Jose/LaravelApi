<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonaRequest;
use App\Models\AdscritaNoadscrita;
use App\Models\Persona;
use App\Models\Pnf;
use Illuminate\Http\Request;
use PDOException;
use PhpParser\Node\Stmt\TryCatch;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Seleccionar las Personas
        $persona = Persona::select(
            'id',
            'cedula_persona',
            'nombre',
            'apellido',
            'direccion',
            'municipio',
            'direccion',
            'telefono',
            'email',
            'tipo_persona',
            'grado_inst'
        )
            ->get();

        // Enviar a la vista del listado de Personas con la variable
        return response()->json($persona);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        // Gardando los registros
        Persona::create($request->all());
        // retornando confirmacion a la vista
        return response()->json(["message" => "Persona Registrada"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Persona $persona)
    {
        // enviando datos al frontend
        return response()->json($persona);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Persona $persona)
    {
        // Editando registro
        $persona->update($request->all());

        // Enviando respuesta al frontend
        return response()->json(['message' => 'Persona Editada']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $persona)
    {
        // Eliminando Persona
        $persona->delete();

        // Enviando respuesta a la api
        return response()->json(['message' => 'Persona Eliminada'], 200);
    }

    public function getPnf()
    {
        $pnfs = Pnf::select('id', 'nombre')->get();

        return response()->json($pnfs);
    }
}
