<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coordinador;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoordinadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los Coordinadores
        $coordinadores = Coordinador::with(['docente:id,persona_id,pnf_id', 'docente.persona:id,cedula_persona,nombre,apellido', 'docente.pnf:id,nombre'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($coordinadores);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar los datos básicos
            $request->validate([
                'docente_id' => 'required|exists:docentes,id|unique:coordinadors,docente_id',
            ]);

            // Obtener el docente y su pnf_id
            $docente = Docente::findOrFail($request->docente_id);

            // Verificar si ya existe un coordinador para ese PNF
            $existeCoordinadorPNF = Coordinador::whereHas('docente', function ($q) use ($docente) {
                $q->where('pnf_id', $docente->pnf_id);
            })->exists();

            if ($existeCoordinadorPNF) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe un coordinador para ese PNF',
                ], 400);
            }

            // Guardar Coordinador
            Coordinador::create($request->all());

            return response()->json(['message' => 'Coordinador Registrado']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado',
                'error' => $e->getMessage()
            ], 500);
        }
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
    public function destroy(Coordinador $coordinador)
    {
        try {
            DB::beginTransaction();

            // Eliminando el registro
            $coordinador->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Coordinador Eliminada'
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            // Código de error de restricción de clave foránea en PostgreSQL
            if ($e->getCode() == '23503') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el coordinador porque tiene registros relacionados',
                    'error_type' => 'foreign_key_constraint'
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el coordinador',
                'error' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Ocurrio un error inesperado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDocentes($boolean)
    {
        $Docentes = Docente::with(['persona:id,cedula_persona,nombre,apellido'])->whereDoesntHave('coordinador')->get();


        $Docentes = $Docentes->map(function ($docente) {
            return [
                'id' => $docente->id,
                'nombre' => $docente->persona->nombre . ' ' . $docente->persona->apellido . ' - ' . $docente->persona->cedula_persona,
            ];
        });

        if ($boolean) {
            $DocentesIds = Docente::with(['persona:id,cedula_persona,nombre,apellido'])->get();
            $DocentesEdit = $DocentesIds->map(function ($docente) {
                return [
                    'id' => $docente->id,
                    'nombre' => $docente->persona->nombre . ' ' . $docente->persona->apellido . ' - ' . $docente->persona->cedula_persona,
                ];
            });
        }

        return response()->json([
            'docentes' => $Docentes,
            'docentesEdit' => $boolean ? $DocentesIds : null,
        ], 200);
    }
}
