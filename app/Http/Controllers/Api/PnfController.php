<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePnfRequest;
use App\Http\Requests\UpdatePnfRequest;
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
        $pnfs = Pnf::select('id', 'nombre', 'abreviado', 'abreviado_coord')->get();

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
    public function destroy(Pnf $pnf) {

        // Eliminando el pnf
        $pnf->delete();
        
        // Enviando respuesta a la api
        return response()->json(['message' => 'PNF Eliminado'], 200);
    }
}
