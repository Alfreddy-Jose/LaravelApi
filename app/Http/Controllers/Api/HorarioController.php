<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHorarioRequest;
use App\Models\Horario;
use App\Models\Seccion;
use App\Models\Trimestre;
use DragonCode\Contracts\Cache\Store;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index($seccionId)
    {
        return Horario::with(['trimestre'])
            ->where('seccion_id', $seccionId)
            ->orderByDesc('created_at')
            ->get();
    }


    public function show(Horario $horario)
    {
        $evento = $horario->Clase()
            ->with(['unidadCurricular', 'docente.persona', 'espacio', 'sede', 'pnf', 'trimestre', 'trayecto'])
            ->get();

        return response()->json($evento);
    }

    // funcion para mostrar todos los horarios
    public function index2()
    {
        return Horario::with(['trimestre', 'seccion'])
            ->orderByDesc('created_at')
            ->get();
    }
    public function store(StoreHorarioRequest $request, $seccionId)
    {
        // Verificar unicidad (seccion + trimestre)
        $existe = Horario::where('seccion_id', $seccionId)
            ->where('trimestre_id', $request['trimestre_id'])
            ->exists();
        if ($existe) {
            return response()->json([
                'message' => 'Ya existe un horario para esta sección en ese trimestre.'
            ], 422);
        }

        // (Opcional) Regla “máx 3 publicados por año”: se controla al publicar.
        $horario = Horario::create([
            'seccion_id'   => $seccionId,
            'trimestre_id' => $request['trimestre_id'],
            'nombre'       => $request['nombre'] ?? null,
            'estado'       => 'borrador',
            'lapso_academico' => $request->lapso_academico
        ]);
        // Retornar id del horario creado
        return response()->json($horario->load('trimestre'), 201);
    }

    public function horario(Horario $horario)
    {
        // retornar horario con todas sus relaciones y datos de la seccion
        /* return response()->json($horario->load('trimestre', 'seccion', 'seccion.sede[id, nombre_sede]', 'seccion.pnf', 'seccion.trayecto')); */
        return response()->json($horario->load([
            'trimestre' => function ($query) {
                $query->select('id', 'nombre', 'trayecto_id');
            },
            'seccion' => function ($query) {
                $query->select('id', 'nombre', 'pnf_id', 'matricula_id', 'trayecto_id', 'sede_id', 'lapso_id', 'numero_seccion', 'nombre')
                    ->with(['pnf' => function ($query) {
                        $query->select('id', 'nombre');
                    }, 'trayecto' => function ($query) {
                        $query->select('id', 'nombre');
                    }]);
            },
            'seccion.pnf',
            'seccion.trayecto',
            'seccion.sede' => function ($query) {
                $query->select('id', 'nombre_sede');
            }
        ]));
    }

    public function destroy(Horario $horario)
    {
        // Eliminando Horario
        $horario->delete();
        // Enviando respuesta al frontend
        return response()->json(["message" => "Horario Eliminado"]);
    }
}
