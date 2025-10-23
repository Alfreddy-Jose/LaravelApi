<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioPublicacionController extends Controller
{
    public function publicar(Request $request, Horario $horario)
    {
        $horario->load('seccion.lapso');

        if (!$horario->seccion || !$horario->seccion->lapso) {
            return response()->json([
                'message' => 'La sección no tiene un lapso académico asignado.'
            ], 422);
        }

        $lapsoId = $horario->seccion->lapso->id;

        $publicadosMismoAnio = Horario::where('seccion_id', $horario->seccion_id)
            ->whereHas('seccion.lapso', fn($q) => $q->where('id', $lapsoId))
            ->where('estado', 'publicado')
            ->count();


        if ($publicadosMismoAnio >= 3) {
            return response()->json([
                'message' => 'Ya hay 3 horarios publicados para esta sección en este año académico.'
            ], 422);
        }

        $horario->update(['estado' => 'publicado']);

        return response()->json($horario->fresh('trimestre'));
    }
}
