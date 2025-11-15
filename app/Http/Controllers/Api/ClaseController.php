<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClaseRequest;
use App\Models\Clase;
use App\Models\Horario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clase = Clase::with([
            'unidadCurricular',
            'docente.persona',
            'espacio',
        ])->get();

        return response()->json($clase);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClaseRequest $request)
    {
        try {
            $data = $request->validated();

            $horario = Horario::findOrFail($data['horario_id']);
            $lapso_academico = $horario->lapso_academico;
            Log::info('lapso_academico: ' . $lapso_academico);
            // Verificación con 8 parámetros (sin trayecto_id)
            $disponible = DB::selectOne("
            SELECT verificar_bloques_consecutivos_disponibles(?, ?, ?, ?, ?, ?, ?, ?) as disponible
        ", [
                $data['espacio_id'],
                $data['docente_id'],
                $data['dia'],
                $data['bloque_id'],
                $data['duracion'],
                $data['trimestre_id'],
                $lapso_academico,
                $data['horario_id']
            ]);
            Log::info('disponibilidad: ' . json_encode($disponible));
            if (!$disponible->disponible) {
                return response()->json([
                    'message' => 'Verifique la disponibilidad del aula y el docente en el bloque de hora que se quieren ingresar en este trimestre.'
                ], 422);
            }

            $clase = $horario->Clase()->create($data);

            return response()->json([
                "message" => "Clase Registrada",
                "clase"   => $clase
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'No se pudo crear la clase',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Clase $c)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Clase $clase)
    {
        try {
            $clase->update([
                "unidad_curricular_id" => $request->unidad_curricular_id,
                "docente_id" => $request->docente_id,
                "espacio_id" => $request->espacio_id,
            ]);
            return response()->json(['message' => 'Clase editada'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al editar la clase'], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clase $clase)
    {
        try {
            $clase->update([
                "bloque_id" => $request->bloque_id,
                "duracion" => $request->duracion,
                "dia" => $request->dia,
            ]);
            return response()->json(['message' => 'Clase editada'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al editar la clase'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clase $clase)
    {
        // Eliminando evento
        $clase->delete();

        // Devolviendo respuesta a la api
        return response()->json(['message' => 'Clase Eliminada'], 200);
    }

    public function generarPDF($horarioId)
    {
        try {
            // Buscar el horario con todas las relaciones necesarias
            $horario = \App\Models\Horario::with([
                'seccion.trayecto',
                'seccion.pnf',
                'seccion.sede',
                'seccion.lapso',
                'trimestre',
                'clase' => function ($query) {
                    $query->with([
                        'unidadCurricular',
                        'espacio',
                        'docente.persona',
                        'bloque'
                    ]);
                }
            ])->findOrFail($horarioId);

            // Traer bloques desde la BD
            $bloques = \App\Models\BloquesTurno::ordenados()->get()->toArray();

            // Crear un mapa de ID a posición secuencial
            $mapaIdAPosicion = [];
            foreach ($bloques as $index => $bloque) {
                $mapaIdAPosicion[$bloque['id']] = $index + 1; // Posición comienza en 1
            }

            // Días normalizados (sin acentos, en mayúsculas)
            $dias = ["LUNES", "MARTES", "MIÉRCOLES", "JUEVES", "VIERNES", "SÁBADO"];

            // Mapeo de variaciones a días normalizados
            $mapeoDias = [
                'lunes' => 'LUNES',
                'LUNES' => 'LUNES',
                'martes' => 'MARTES',
                'MARTES' => 'MARTES',
                'miércoles' => 'MIÉRCOLES',
                'miercoles' => 'MIÉRCOLES',
                'MIÉRCOLES' => 'MIÉRCOLES',
                'MIERCOLES' => 'MIÉRCOLES',
                'jueves' => 'JUEVES',
                'JUEVES' => 'JUEVES',
                'viernes' => 'VIERNES',
                'VIERNES' => 'VIERNES',
                'sábado' => 'SÁBADO',
                'sabado' => 'SÁBADO',
                'SÁBADO' => 'SÁBADO',
                'SABADO' => 'SÁBADO'
            ];

            // Procesar las clases a eventos
            $eventosProcesados = [];
            foreach ($horario->clase as $clase) {
                $bloque_id = $clase->bloque_id;
                $bloque_fin_id = $bloque_id + $clase->duracion - 1;

                // Convertir IDs a posiciones secuenciales
                $posicion_inicio = $mapaIdAPosicion[$bloque_id] ?? null;
                $posicion_fin = $mapaIdAPosicion[$bloque_fin_id] ?? null;

                if ($posicion_inicio === null || $posicion_fin === null) {
                    Log::warning("No se pudo mapear bloque ID: {$bloque_id} o {$bloque_fin_id} a posición");
                    return null;
                }

                // Normalizar el día - CON VALIDACIÓN MEJORADA
                $diaOriginal = trim($clase->dia);
                $diaLower = strtolower($diaOriginal);

                // Verificar en el mapeo
                if (isset($mapeoDias[$diaLower])) {
                    $diaNormalizado = $mapeoDias[$diaLower];
                } elseif (isset($mapeoDias[$diaOriginal])) {
                    $diaNormalizado = $mapeoDias[$diaOriginal];
                } else {
                    // Log para debugging y valor por defecto
                    Log::warning("Día no reconocido: '{$diaOriginal}', usando LUNES por defecto");
                    $diaNormalizado = 'LUNES';
                }

                $eventosProcesados[] = [
                    'id' => $clase->id,
                    'dia' => $diaNormalizado,
                    'bloque' => $posicion_inicio,
                    'bloque_inicio' => $posicion_inicio,
                    'bloque_fin' => $posicion_fin,
                    'duracion' => $clase->duracion,
                    'materia' => $clase->unidadCurricular->nombre ?? '',
                    'docente' => $clase->docente->persona->nombre . ' ' . $clase->docente->persona->apellido,
                    'aula' => $clase->espacio->nombre_aula ?? '',
                    'color' => '#e3f2fd', // Color por defecto, igual que en tu frontend
                ];
            }

            Log::info("Eventos procesados: " . count($eventosProcesados));

            // Obtener información de laboratorios (espacios de tipo laboratorio)
            $laboratorios = [];
            $clasesEnLaboratorios = $horario->clase->filter(function ($clase) {
                return $clase->espacio && $clase->espacio->tipo_espacio === 'LABORATORIO';
            });

            foreach ($clasesEnLaboratorios as $clase) {
                $laboratorioInfo = $clase->espacio->nombre_aula . ': ' . $clase->unidadCurricular->nombre;
                if (!in_array($laboratorioInfo, $laboratorios)) {
                    $laboratorios[] = $laboratorioInfo;
                }
            }

            // Encabezado con información del horario (misma estructura que tu frontend)
            $encabezado = [
                'sede' => $horario->seccion->sede->nombre_sede ?? null,
                'trayecto' => $horario->seccion->trayecto->nombre ?? null,
                'trimestre' => $horario->trimestre->nombre_relativo ?? null,
                'seccion' => $horario->seccion->nombre ?? null,
                'lapso' => $horario->seccion->lapso->nombre_lapso ?? null,
                'laboratorios' => $laboratorios,
                'pnf' => $horario->seccion->pnf->nombre ?? null,
                'pnf_abreviado' => $horario->seccion->pnf->abreviado ?? null
            ];

            Log::info("Encabezado preparado:", $encabezado);

            // Preparar datos para la vista (EXACTAMENTE la misma estructura que tu frontend)
            $data = [
                'encabezado' => $encabezado,
                'bloques' => $bloques,
                'eventos' => $eventosProcesados,
                'dias' => $dias,
                'bloqueHeight' => 25 // Exactamente igual que en tu vista
            ];

            Log::info("Datos preparados para la vista");

            // Generar PDF
            $pdf = Pdf::loadView('pdf.horario', $data)
                ->setPaper('a4', 'landscape')
                ->setOption('enable_html5_parser', true);

            // Nombre del archivo personalizado
            $nombreArchivo = "horario_seccion_" .
                \Illuminate\Support\Str::slug($encabezado['seccion']) . "_" .
                \Illuminate\Support\Str::slug($encabezado['trimestre']) . ".pdf";

            Log::info("PDF generado exitosamente: {$nombreArchivo}");

            return $pdf->download($nombreArchivo);
        } catch (\Exception $e) {
            Log::error("❌ ERROR generando PDF: " . $e->getMessage());
            Log::error("📋 Trace: " . $e->getTraceAsString());

            return response()->json([
                'error' => 'Error generando PDF',
                'details' => $e->getMessage(),
                'trace' => env('APP_DEBUG') ? $e->getTraceAsString() : 'Oculto en producción'
            ], 500);
        }
    }
}
