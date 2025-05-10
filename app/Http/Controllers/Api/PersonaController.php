<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Seleccionar las Personas
        $persona = Persona::select('id', 'cedula_persona', 'nombre', 'apellido', 'direccion', 'municipio', 'direccion', 'telefono', 'email', 'tipo_persona', 'grado_inst')->get();

        // Enviar a la vista del listado de Personas con la variable
        return response()->json($persona);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Gardando los registros
        Persona::create($request->all());
        
        // retornando confirmacion a la vista
        return response()->json(["message" => "Persona Registrada"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Persona $id)
    {
        // enviando datos al frontend
        return response()->json($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $id)
    {
        // Eliminando Persona
        $id->delete();
        
        // Enviando respuesta a la api
        return response()->json(['message' => 'Persona Eliminada'], 200);
    }
}
