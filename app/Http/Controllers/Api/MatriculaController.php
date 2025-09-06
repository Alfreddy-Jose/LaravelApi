<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMatriculaRequest;
use App\Http\Requests\UpdateMatriculaRequest;
use App\Models\Matricula;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Seleccionando todos los tipos de matricula
        $matriculas = Matricula::select('id', 'nombre', 'numero')->get();

        // enviando datos a la api
        return response()->json($matriculas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatriculaRequest $request)
    {
        // Creando Tipo de Matricula
        Matricula::create($request->all());

        // Enviando respuesta a la api
        return response()->json(['message' => 'Matricula Registrada'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Matricula $matricula)
    {
        return response()->json($matricula);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatriculaRequest $request, Matricula $matricula)
    {

        // Actualizando registro
        $matricula->update($request->all()); // <-- variable $id es el registro captado

        return response()->json(["message" => "Matricula Editada"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matricula $matricula)
    {
        $matricula->delete();

        return response()->json(["message" => "Matricula Eliminada"], 200);
    }

    public function generarPDF()
    {
        $matriculas = Matricula::select('id', 'nombre', 'numero')->get();

        $pdf = Pdf::loadView('pdf.matricula', compact('matriculas'));
        return $pdf->download('TipoMatricula.pdf');
    }
}