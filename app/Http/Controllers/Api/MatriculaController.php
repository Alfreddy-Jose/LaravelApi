<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Seleccionando todos los tipos de matricula
        $matriculas = Matricula::select('id', 'nombre', 'tipo')->get();

        // enviando datos a la api
        return response()->json($matriculas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Creando Tipo de Matricula
        Matricula::create($request->all());

        // Enviando respuesta a la api
        return response()->json(['message' => 'Matricula Registrada']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Matricula $id)
    {
        return response()->json($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matricula $id)
    {

        // Actualizando registro
        $id->update($request->all()); // <-- variable $id es el registro captado

        return response()->json(["message" => "Matricula Editada"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
