<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        // creando nueva sede
        Sede::create($request->all());

        // Enviando respuesta al frontend
        return response()->json(['message' => 'Sede Registrada']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sede $id) // <-- almacenando datos en la variable $id
    {
        // enviando datos al frontend
        return response()->json($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sede $id)
    {
        // Editando registro
        $id->update($request->all());
        
        // Enviando respuesta al frontend
        return response()->json(['message' => 'Sede Editada']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
