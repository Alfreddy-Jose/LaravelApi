<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUniversidadRequest;
use App\Http\Requests\UpdateUniversidadRequest;
use App\Models\Universidad;
use Illuminate\Http\Request;

class UniversidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $universidades = Universidad::select(
            'id',
            'nombre_univ',
            'abreviado_univ',
            'rif_univ',
            'direccion'
        )->get();

        // Si no hay registros, devuelve un array vacío para que el frontend lo maneje
        if ($universidades->isEmpty()) {
            return response()->json([], 200);
        }

        return response()->json($universidades, 200);
    }

    /** 
     * Store a newly created resource in storage.
     */
    public function store(StoreUniversidadRequest $request)
    {
        Universidad::create($request->validated());

        return response()->json(["message" => "Universidad Registrada"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $universidad = Universidad::select('id')->first();

        if (!$universidad) {
            return response()->json([], 200);
        }

        return response()->json($universidad, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUniversidadRequest $request, Universidad $universidad)
    {
        $universidad->update($request->validated());

        return response()->json(["message" => "Universidad Actualizada"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getUniversidad()
    {
        $universidad = Universidad::first(); // Usar first() en lugar de get()

        if (!$universidad) {
            return response()->json(['message' => 'No se encontró información de la universidad'], 404);
        }

        return response()->json($universidad);
    }
}
