<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePnfRequest;
use App\Http\Requests\UpdatePnfRequest;
use App\Models\Pnf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PnfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Seleccionar los pnf
        $pnfs = Pnf::select('id', 'codigo', 'nombre', 'abreviado', 'abreviado_coord')->get();

        // Enviar a la vista del listado de PNF con la variable
        return response()->json($pnfs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePnfRequest $request)
    {

        Pnf::create($request->all());

        return response()->json(["message" => "PNF Registrado"], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pnf $pnf)
    {
        return response()->json($pnf);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePnfRequest $request, Pnf $pnf)
    {

        // actualizando pnf
        $pnf->update($request->all());

        // Enviando respuesta a la api
        return response()->json(['message' => 'PNF Editado'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pnf $pnf)
    {
        try {
            DB::beginTransaction();

            // Eliminando pnf
            $pnf->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'PNF Eliminado'
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            // Código de error de restricción de clave foránea en MySQL
            if ($e->getCode() == '23503') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el PNF porque tiene registros relacionados',
                    'error_type' => 'foreign_key_constraint'
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el PNF',
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

    public function generarPDF()
    {
        $pnfs = Pnf::select('id', 'codigo', 'nombre', 'abreviado', 'abreviado_coord')->get();

        $pdf = Pdf::loadView('pdf.pnf', compact('pnfs'));

        return $pdf->download('pnfs.pdf');
    } 
}
