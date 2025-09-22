<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index($seccionId)
    {
        return $seccionId->horarios()
            ->with(['clases.unidadCurricular', 'clases.docente', 'clases.aula', 'trimestre'])
            ->get();
    }

    public function store(Request $request, $seccionId)
    {
        $data = $request->validate([
            'trimestre_id' => ['required', 'exists:trimestres,id'],
            'nombre'       => ['nullable', 'string', 'max:150'],
        ]);

        // Verificar unicidad (seccion + trimestre)
        $existe = Horario::where('seccion_id', $seccionId)
            ->where('trimestre_id', $data['trimestre_id'])
            ->exists();
        if ($existe) {
            return response()->json([
                'message' => 'Ya existe un horario para esta sección en ese trimestre.'
            ], 422);
        }

        // (Opcional) Regla “máx 3 publicados por año”: se controla al publicar.
        $horario = Horario::create([
            'seccion_id'   => $seccionId,
            'trimestre_id' => $data['trimestre_id'],
            'nombre'       => $data['nombre'] ?? null,
            'estado'       => 'borrador',
            'lapso_academico' => $request->lapso_academico
        ]);

        return response()->json($horario->load('trimestre'), 201);
    }
}
