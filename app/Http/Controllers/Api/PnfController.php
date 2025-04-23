<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pnf;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        Pnf::create($request->all());

        return response()->json(["message" => "PNF Registrado"], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pnf $id)
    {
        return response()->json($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pnf $id)
    {

        // actualizando pnf
        $id->update($request->all());

        // Enviando respuesta a la api
        return response()->json(['message' => 'PNF Actualizado', 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
