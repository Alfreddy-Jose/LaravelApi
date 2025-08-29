<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trayecto;
use Illuminate\Http\Request;

class TrayectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trayectos = Trayecto::select('id', 'nombre')->get();

        return response()->json($trayectos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validando
        $request->validate([
            'nombre' => 'required|string|unique:trayectos,nombre'
        ]);
        
        // guardando el trayecto
        Trayecto::create($request->all());

        return response()->json(['message' => 'Trayecto Registrado'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trayecto $trayecto)
    {
        return response()->json($trayecto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|unique:trayectos,nombre'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trayecto $trayecto)
    {
        // Eliminando trayecto
        $trayecto->delete();
        
        // Enviando respuesta
        return response()->json(['message' => 'Trayecto Eliminado']);
    }
}
