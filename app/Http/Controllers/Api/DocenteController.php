<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocenteRequest;
use App\Models\CondicionContrato;
use App\Models\Docente;
use App\Models\Persona;
use App\Models\Pnf;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$docentes = Docente::with('')
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocenteRequest $request)
    {
        $docente = new Docente();
        $docente->persona_id = $request->persona_id;
        $docente->pnf_id = $request->pnf_id;
        $docente->categoria = $request->categoria;

        if ($docente->save()) {
            $condicion_contrato = new CondicionContrato();
            $condicion_contrato->fecha_inicio = $request->fecha_inicio;
            $condicion_contrato->fecha_fin = $request->fecha_fin;
            $condicion_contrato->dedicacion = $request->dedicacion;
            $condicion_contrato->tipo = $request->tipo;
            $condicion_contrato->docente_id = $docente->id;
            $condicion_contrato->save();

            return response()->json(["message" => "Docente Registrado"], 200);
        }

        return response()->json(["message" => "Error al Registrar Docente"], 500);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }

    public function getDataSelect()
    {
        $pnfs = Pnf::select('id', 'nombre')->get();
        $docentes = Persona::where('tipo_persona', 'DOCENTE')->select('id', 'nombre')->get();

        return response()->json([
            'pnf' => $pnfs,
            'docentes' => $docentes,
        ], 200);
    }
}
