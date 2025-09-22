<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSedeRequest;
use App\Http\Requests\UpdateSedeRequest;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Pnf;
use App\Models\Sede;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las sedes
        $sedes = Sede::with('municipio:municipio,id_municipio')
            ->select('id', 'nro_sede', 'nombre_sede', 'nombre_abreviado', 'direccion', 'municipio_id')
            ->get();

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
        $sede->load(['municipio' => function ($query) {
            $query->select('id_municipio', 'municipio', 'id_estado')
                ->with(['estado' => function ($query) {
                    $query->select('id_estado', 'estado');
                }]);
        }]);

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

    public function generaPDF()
    {
        // Obtener todas las sedes
        $sedes = Sede::with('municipio:municipio,id_municipio')
            ->select('id', 'nro_sede', 'nombre_sede', 'nombre_abreviado', 'direccion', 'municipio_id')
            ->get();

        $pdf = Pdf::loadView('pdf.sedes', compact('sedes'));

        return $pdf->download('sedes.pdf');
    }

    public function getEstados()
    {
        $estados = Estado::all();
        // transformar todos los estados en mayusculas
        $estados->transform(function ($estado) {
            $estado->estado = strtoupper($estado->estado);
            return $estado;
        });
        return response()->json($estados);
    }

    public function getMunicipios($estado)
    {
        // traer todos los municipios de un estado 
        $municipios = Municipio::where('id_estado', $estado)->get();
        // transformar todos los municipios en mayusculas
        $municipios->transform(function ($municipio) {
            $municipio->municipio = strtoupper($municipio->municipio);
            return $municipio;
        });

        return response()->json($municipios);
    }
}
