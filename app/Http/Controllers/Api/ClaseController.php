<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClaseRequest;
use App\Models\Clase;
use App\Models\Horario;
use Barryvdh\DomPDF\Facade\Pdf;
use DragonCode\Contracts\Cache\Store;
use Illuminate\Http\Request;
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

            // Verificamos el horario
            $horario = Horario::findOrFail($data['horario_id']);
            Log::info($data);

            // Validar solapamiento: misma sección, mismo día, mismo rango de bloques
            $haySolapamiento = $horario->Clase()
                ->where('dia', $data['dia'])
                ->where('docente_id', $data['docente_id'])
                ->where(function ($q) use ($data) {
                    $q->whereBetween('bloque_id', [
                        $data['bloque_id'],
                        $data['bloque_id'] + $data['duracion'] - 1
                    ]);
                })
                ->exists();

            if ($haySolapamiento) {
                return response()->json([
                    'message' => 'Ya existe una clase en ese rango de bloques en este horario.'
                ], 422);
            }

            // Crear la clase
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

    public function generarPDF(Request $request)
    {

        Log::info('Generando PDF', $request->all());
        try {
            // Proporcionar valores por defecto para encabezado
            $encabezado = $request->input('encabezado', []);
            Log::info("Encabezado recibido:", $request->input('encabezado', []));

            $bloques = $request->input('bloques', []);
            $eventos = $request->input('eventos', []);
            Log::info("Eventos recibidos:", $request->input('eventos', []));

            // Creamos un array de horas de inicio de cada bloque para buscar el índice fácilmente
            $bloqueHoras = array_map(function ($bloque) {
                // Extrae la hora de inicio del rango
                return trim(explode('-', $bloque['rango'])[0]);
            }, $bloques);

            // Procesamos los eventos para agregar bloque_inicio y bloque_fin
            $eventosProcesados = [];
            foreach ($eventos as $evento) {
                // Busca el índice del bloque donde inicia el evento
                $bloque_inicio = $evento['bloque'];
                if ($bloque_inicio === false) {
                    // Si no encuentra el bloque, puedes omitir el evento o lanzar un error
                    continue;
                }
                $bloque_fin = $bloque_inicio + $evento['duracion'] - 1;

                $eventosProcesados[] = array_merge($evento, [
                    'bloque_inicio' => $bloque_inicio,
                    'bloque_fin' => $bloque_fin,
                ]);
            }

            $data = [
                'encabezado' => $encabezado,
                'bloques' => $bloques,
                'eventos' => $eventosProcesados,
                'dias' => $request->input('dias', []),
                'bloqueHeight' => 25
            ];

            // En el controlador
            Log::info('Datos enviados a la vista:', $data);
            Log::info('Eventos procesados:', $eventosProcesados);

            // Generar PDF
            $pdf = Pdf::loadView('pdf.horario', $data)
                ->setPaper('a4', 'landscape')
                ->setOption('enable_html5_parser', true);

            return $pdf->download('horario.pdf');
        } catch (\Exception $e) {
            Log::error('Error generando PDF: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error generando PDF',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
