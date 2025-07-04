<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeccionRequest;
use App\Models\LapsoAcademico;
use App\Models\Matricula;
use App\Models\Pnf;
use App\Models\Seccion;
use App\Models\Sede;
use App\Models\Trayecto;
use Illuminate\Http\Request;

class SeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeccionRequest $request)
    {
        // Buscar los datos relacionados usando los IDs recibidos
        $pnf = Pnf::findOrFail($request->pnf_id); // Para obtener el id (ya lo tienes)
        $matricula = Matricula::findOrFail($request->matricula_id); // Para obtener el numero
        $trayecto = Trayecto::findOrFail($request->trayecto_id); // Para obtener el nombre
        $sede = Sede::findOrFail($request->sede_id); // Para obtener el nro_sede

        // Construir el nombre de la sección
        $nombre = $pnf->id . '-' . $matricula->numero . '-' . $trayecto->nombre . '-' . $sede->nro_sede . '-' . $request->numero_seccion;

        // Crear la sección
        $seccion = new Seccion();
        $seccion->pnf_id = $request->pnf_id;
        $seccion->matricula_id = $request->matricula_id;
        $seccion->trayecto_id = $request->trayecto_id;
        $seccion->sede_id = $request->sede_id;
        $seccion->lapso_id = $request->lapso_id;
        $seccion->numero_seccion = $request->numero_seccion;
        $seccion->nombre = $nombre;
        $seccion->save();

        return response()->json(['message' => 'Sección creada correctamente'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

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
        $trayectos = Trayecto::select('id', 'nombre')->get();
        $tipo_matricula = Matricula::select('id', 'nombre', 'numero')->get();
        $sedes = Sede::select('id', 'nro_sede', 'nombre_sede')->get();
        $lapsos = LapsoAcademico::select('id', 'nombre_lapso', 'ano')->get();

        return response()->json([
            "pnfs" => $pnfs,
            "trayectos" => $trayectos,
            "tipo_matricula" => $tipo_matricula,
            "sedes" => $sedes,
            "lapsos" => $lapsos
        ]);
    }
}
