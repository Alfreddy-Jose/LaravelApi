<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHorarioRequest;
use App\Models\Horario;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function verificarHorarioAnterior(Seccion $seccion, Request $request)
    {
        try {
            $trimestreActual = $request->query('trimestre_actual');

            $horarioAnterior = Horario::where('seccion_id', $seccion->id)
                ->where('trimestre_id', '<', $trimestreActual)
                ->orderBy('trimestre_id', 'desc')
                ->first();

            return response()->json([
                'existe_anterior' => !is_null($horarioAnterior),
                'horario_anterior' => $horarioAnterior
            ]);
        } catch (\Exception $e) {
            Log::error('Error verificando horario anterior: ' . $e->getMessage());
            return response()->json([
                'existe_anterior' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear horario automático basado en horario anterior
     */
    public function crearHorarioAutomatico(Horario $horario, Request $request)
    {
        DB::beginTransaction();

        try {
            $seccionId = $request->input('seccion_id');
            $trimestreId = $request->input('trimestre_id');

            // Verificar que el horario existe y pertenece a la sección
            if ($horario->seccion_id != $seccionId) {
                throw new \Exception('El horario no pertenece a la sección especificada');
            }

            // En el controller, antes de ejecutar la función
            Log::info("Ejecutando crear_horario_automatico para horario: " . $horario->id);
            Log::info("Parámetros: seccion_id=$seccionId, trimestre_id=$trimestreId");

            // Ejecutar la función PostgreSQL
            $resultado = DB::select(
                "SELECT crear_horario_automatico(?, ?, ?) as resultado",
                [$horario->id, $seccionId, $trimestreId]
            );

            $resultadoJson = json_decode($resultado[0]->resultado, true);

            if ($resultadoJson['success']) {
                DB::commit();
                return response()->json($resultadoJson);
            } else {
                DB::rollBack();
                return response()->json($resultadoJson, 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creando horario automático: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor: ' . $e->getMessage(),
                'clases_creadas' => 0,
                'conflictos_resueltos' => 0,
                'advertencias' => []
            ], 500);
        }
    }
}
