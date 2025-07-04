<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnidadCurricularRequest;
use App\Http\Requests\UpdateUnidadCurricularRequest;
use App\Models\Trimestre;
use App\Models\UnidadCurricular;
use Illuminate\Http\Request;

class UnidadCurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unidades = UnidadCurricular::with('trimestre')->get();

        return response()->json($unidades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnidadCurricularRequest $request)
    {
        UnidadCurricular::create($request->all());

        return response()->json(['message' => 'Unidad Curricular Registrada']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Obtener datos del registro a actualizar
        $unidad_curricular = UnidadCurricular::with('trimestre')->findOrFail($id);
        return response()->json($unidad_curricular);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnidadCurricularRequest $request, UnidadCurricular $unidad_curricular)
    {
        // Actualizando el registro
        //$unidad_curricular = UnidadCurricular::findOrFail($id);
        $unidad_curricular->update($request->all());
        return response()->json(['message' => 'Unidad Curricular Editada']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnidadCurricular $unidad_curricular)
    {
        $unidad_curricular->delete();

        return response()->json(['message' => 'Unidad Curricular Eliminada']);
    }

    // Metodo para obtener los trimestres
    public function get_trimestres()
    {
        $trimestres = Trimestre::select('id', 'nombre')->get();

        return response()->json($trimestres);
    }
}
