<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUniversidadRequest;
use App\Http\Requests\UpdateUniversidadRequest;
use App\Models\Universidad;
use Illuminate\Support\Facades\Storage;
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
            'direccion',
            'logo',
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
        $logoPath = null;
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            // Log::info('Avatar guardado en:', ['path' => $avatarPath]);
        }

        // Crear el Universidad
        $user = Universidad::create([
            'rif_univ' => $request['rif_univ'],
            'nombre_univ' => $request['nombre_univ'],
            'abreviado_univ' => $request['abreviado_univ'],
            'direccion' => $request['direccion'],
            'logo' => $logoPath,
        ]);
        // Universidad::create($request->validated());

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
    public function update(UpdateUniversidadRequest $request, $universidad)
    {
        $universidad = Universidad::findOrFail($universidad);

        try {
            // Inicializar con el logo actual
            $logoPath = $universidad->logo;

            // Procesar eliminación del logo
            if ($request->has('remove_logo') && $request->boolean('remove_logo')) {
                // Eliminar logo existente del storage
                if ($universidad->logo && Storage::disk('public')->exists($universidad->logo)) {
                    Storage::disk('public')->delete($universidad->logo);
                }
                $logoPath = null;
            }

            // Procesar nuevo logo
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                // Eliminar logo anterior si existe
                if ($universidad->logo && Storage::disk('public')->exists($universidad->logo)) {
                    Storage::disk('public')->delete($universidad->logo);
                }
                // Guardar nuevo logo
                $logoPath = $request->file('logo')->store('logos', 'public');
            }

            // Actualizar universidad
            $universidad->update([
                'rif_univ' => $request['rif_univ'],
                'nombre_univ' => $request['nombre_univ'],
                'abreviado_univ' => $request['abreviado_univ'],
                'direccion' => $request['direccion'],
                'logo' => $logoPath,
            ]);

            return response()->json(["message" => "Universidad Editada"], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la Universidad',
                'error' => $e->getMessage()
            ], 500);
        }
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
