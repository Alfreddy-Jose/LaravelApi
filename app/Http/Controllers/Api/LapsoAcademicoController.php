<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLapsoAcademicoRequest;
use App\Http\Requests\UpdateLapsoAcademicoRequest;
use App\Models\LapsoAcademico;
use App\Models\TipoLapso;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LapsoAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Seleccionando datos del Lapso Academico
        $lapsos = LapsoAcademico::with('tipolapso')->get();

        // Retornando los datos al Frontend
        return response()->json($lapsos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLapsoAcademicoRequest $request)
    {
        // Creando registro
        LapsoAcademico::create($request->all());

        // Enviando respuesta al frontend
        return response()->json(["message" => "Lapso Academico Registrado"]);
    }

    /**
     * Display the specified resource. 
     */
    public function show(LapsoAcademico $lapso_academico)
    {
        // Enviando registro al forntend
        return response()->json($lapso_academico);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLapsoAcademicoRequest $request, LapsoAcademico $lapso_academico)
    {
        // Editando Registro
        $lapso_academico->update($request->all());

        return response()->json(["message" => "Lapso Academico Editado"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LapsoAcademico $lapso_academico)
    {
        // Eliminando Lapso Academico
        $lapso_academico->delete();
        // Enviando respuesta al frontend
        return response()->json(["message" => "Lapso Academico Eliminado"]);
    }

    // Obtener los tipos de lapsos
    public function get_tipoLapsos()
    {
        $tipoLapsos = TipoLapso::select('id', 'nombre')->get();

        return response()->json($tipoLapsos);
    }

    public function generarPDF()
    {
        $lapsos = LapsoAcademico::with('tipolapso')->get();
        $pdf = Pdf::loadView('pdf.lapsos', compact('lapsos'));
        return $pdf->download('LapsosAcademicos.pdf');
    }
}
