<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSedeRequest;
use App\Http\Requests\UpdateSedeRequest;
use App\Models\Pnf;
use App\Models\Sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las sedes
        $sedes = Sede::select('id', 'nro_sede', 'nombre_sede', 'nombre_abreviado', 'direccion', 'municipio')->get();

        // Enviando datos a la api
        return response()->json($sedes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSedeRequest $request)
    {
        Sede::create($request->all());

        // Enviando respuesta al frontend
        return response()->json(['message' => 'Sede Registrada']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sede $sede)
    {
        // enviando datos al frontend
        return response()->json($sede);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSedeRequest $request, Sede $sede)
    {
        // Editando registro
        $sede->update($request->all());

        // Enviando respuesta al frontend
        return response()->json(['message' => 'Sede Editada']);
    }

    public function asignarPnfs(Request $request, $sedeId)
    {
        // Validar entrada
        $validated = $request->validate([
            'pnf_ids' => 'required|array',
            'pnf_ids.*' => 'exists:pnfs,id'
        ], [
            'pnf_ids.required' => 'Debe seleccionar al menos un PNF',
            'pnf_ids.array' => 'Los PNFs deben ser enviados como arreglo',
            'pnf_ids.*.exists' => 'Uno o más PNFs seleccionados no existen'
        ]);

            // Buscar la sede
            $sede = Sede::findOrFail($sedeId);

            // Sincronizar relaciones (sync elimina previos y agrega nuevos)
            $sede->pnfs()->sync($validated['pnf_ids']);

            // Obtener PNFs actualizados para respuesta
            $pnfsAsignados = $sede->pnfs()->select('pnfs.id', 'pnfs.nombre')->get();

            return response()->json([
                'message' => 'PNFs asignados',
                'assigned_pnfs' => $pnfsAsignados
            ], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sede $sede)
    {
        // Eliminando la Sede
        $sede->delete();

        // Enviando respuesta a la api
        return response()->json(['message' => 'Sede Eliminada'], 200);
    }

    public function getPnf()
    {
        $pnf = Pnf::select('id', 'nombre')->get();

        return response()->json($pnf);
    }

    public function getPnfSede(Sede $sede)
    {
        $carrerasAsignadas = $sede->pnfs()->select('pnfs.id', 'pnfs.nombre')->get();

        return response()->json($carrerasAsignadas);
    }
}
