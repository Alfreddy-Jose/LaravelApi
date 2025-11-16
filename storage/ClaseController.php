<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClaseRequest;
use App\Models\Clase;
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
        return Clase::with([
            'sede',
            'pnf',
            'trayecto',
            'trimestre',
            'unidadCurricular',
            'docente.persona',
            'espacio',
            'bloque'
        ])->get();
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
            $clase = Clase::create($request->all());
            return response()->json(array("message" => "clase registrada", "clase" => $clase, 201));
        } catch (\Exception $e) {
            return response()->json(['No se pudo crear la clase' => $e->getMessage()], 500);
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
    public function edit(Clase $c)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clase $evento)
    {

        try {
            $evento->update([
                "bloque_id" => $request->bloque_id,
                "duracion" => $request->duracion,
                "dia" => $request->dia,
            ]);
            Log::info('clase updated successfully');
            return response()->json(['message' => 'Evento editado'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar Evento'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clase $evento)
    {
        // Eliminando evento
        $evento->delete();

        // Devolviendo respuesta a la api
        return response()->json(['message' => 'Clase eliminada con exito'], 200);
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
