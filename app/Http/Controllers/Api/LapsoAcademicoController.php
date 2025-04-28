<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LapsoAcademico;
use Illuminate\Http\Request;

class LapsoAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Seleccionando datos del Lapso Academico
        $lapsos = LapsoAcademico::select('id', 'nombre_lapso', 'ano', 'tipo_lapso')->get();

        // Retornando los datos al Frontend
        return response()->json($lapsos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Creando registro
        LapsoAcademico::create($request->all());

        // Enviando respuesta al frontend
        return response()->json(["message" => "Lapso Academico Registrado"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(LapsoAcademico $id)
    {
        // Enviando registro al forntend
        return response()->json($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LapsoAcademico $id)
    {
        // Editando Registro
        $id->update($request->all());

        return response()->json(["message" => "Lapso Academico Editado"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LapsoAcademico $id)
    {
        // Eliminando Lapso Academico
        $id->delete();
        // Enviando respuesta al frontend
        return response()->json(["message" => "Lapso Academico Eliminado"]);
    }
}
