<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAulaRequest;
use App\Http\Requests\StoreLaboratoriosRequest;
use App\Http\Requests\UpdateAulaRequest;
use App\Http\Requests\UpdateLaboratorioRequest;
use App\Models\Espacio;
use App\Models\Sede;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class EspacioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexAula()
    {
        $aulas = Espacio::with('sede:id,nombre_sede')
            ->where('tipo_espacio', 'AULA')
            ->select(
                'id',
                'codigo',
                'nombre_aula',
                'etapa',
                'nro_aula',
                'sede_id'
            )
            ->get();
        return response()->json($aulas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeAula(StoreAulaRequest $request)
    {
        // Guardando datos de aula
        $aula = new Espacio();
        $aula->codigo = $request->codigo;
        $aula->etapa = $request->etapa;
        $aula->nro_aula = $request->nro_aula;
        $aula->sede_id = $request->sede_id;
        $aula->tipo_espacio = "AULA";
        $aula->nombre_aula = $request->etapa . '-' . $request->nro_aula;
        $aula->save();

        return response()->json(["message" => "Aula Registrada"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function showAula(Espacio $espacio)
    {
        return response()->json($espacio);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateAula(UpdateAulaRequest $request, Espacio $espacio)
    {
        $espacio->update(
            [
                "etapa" => $request->etapa,
                "nro_aula" => $request->nro_aula,
                "sede_id" => $request->sede_id,
                "codigo" => $request->codigo,
                "nombre_aula" => $request->etapa . '-' . $request->nro_aula
            ]
        );

        return response()->json(["message" => "Aula Editada"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyAula(Espacio $espacio)
    {
        $espacio->delete();

        return response()->json(["message" => "Aula Eliminada"], 201);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexLaboratorio()
    {
        $laboratorios = Espacio::with('sede:id,nombre_sede')
            ->select(
                'id',
                'codigo',
                'nombre_aula',
                'etapa',
                'abreviado_lab',
                'equipos',
                'sede_id'
            )
            ->where('tipo_espacio', 'LABORATORIO')
            ->get();

        return response()->json($laboratorios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeLaboratorio(StoreLaboratoriosRequest $request)
    {
        // Guardando datos de laboratorio
        $laboratorio = new Espacio();
        $laboratorio->codigo = $request->codigo;
        $laboratorio->nombre_aula = $request->nombre_aula;
        $laboratorio->etapa = $request->etapa;
        $laboratorio->abreviado_lab = $request->abreviado_lab;
        $laboratorio->equipos = $request->equipos;
        $laboratorio->sede_id = $request->sede_id;
        $laboratorio->tipo_espacio = "LABORATORIO";
        $laboratorio->save();

        return response()->json(["message" => "Laboratorio Registrado"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function showLaboratorio(Espacio $espacio)
    {
        return response()->json($espacio);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateLaboratorio(UpdateLaboratorioRequest $request, Espacio $espacio)
    {
        $espacio->update($request->validated());

        return response()->json(["message" => "Laboratorio Editado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyLaboratorio(Espacio $espacio)
    {
        $espacio->delete();

        return response()->json(["message" => "Laboratorio Eliminado"], 201);
    }

    public function getSedes()
    {
        $sedes = Sede::select('id', 'nombre_sede')->get();

        return response()->json($sedes);
    }

    public function asignarEspacios(Request $espacios, $pnfId)
    {
        Espacio::where('pnf_id', $pnfId)->update(['pnf_id' => null]); // Limpiar asignaciones previas

        // asignar espacios a un PNF
        Espacio::whereIn('id', $espacios->espacios_ids)
            ->update(['pnf_id' => $pnfId]);

        return response()->json(['message' => 'Espacios asignados'], 200);
    }

    public function aulasPDF()
    {
        $aulas = Espacio::with('sede:id,nombre_sede')
            ->where('tipo_espacio', 'AULA')
            ->select(
                'id',
                'codigo',
                'nombre_aula',
                'etapa',
                'nro_aula',
                'sede_id'
            )->get();

        $pdf = Pdf::loadView('pdf.aulas', compact('aulas'));
        return $pdf->download('aulas.pdf');
    }

    public function laboratoriosPDF()
    {
        $laboratorios = Espacio::with('sede:id,nombre_sede')
            ->select(
                'id',
                'codigo',
                'nombre_aula',
                'etapa',
                'abreviado_lab',
                'equipos',
                'sede_id'
            )
            ->where('tipo_espacio', 'LABORATORIO')
            ->get();

        $pdf = Pdf::loadView('pdf.laboratorios', compact('laboratorios'));
        return $pdf->download('laboratorios.pdf');
    }
}
