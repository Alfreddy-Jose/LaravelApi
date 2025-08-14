<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHorarioRequest;
use App\Models\Horario;
use Barryvdh\DomPDF\Facade\Pdf;
use DragonCode\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Horario::with([
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
    public function store(StoreHorarioRequest $request)
    {
        try {
            $horario = Horario::create($request->all());
            return response()->json($horario, 201);
        } catch (\Exception $e) {
            return response()->json(['No se pudo crear el horario' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Horario $c)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $c)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horario $c)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horario $evento)
    {
        // Eliminando evento
        $evento->delete();
        // Devolviendo respuesta a la api
        return response()->json(['message' => 'Evento eliminado con exito'], 200);
    }

    public function generarPDF(Request $request)
    {
        try {


            // Validar datos recibidos
            $validated = $request->validate([
                'encabezado' => 'sometimes|array', // Cambiado a 'sometimes'
                'bloques' => 'required|array',
                'eventos' => 'required|array',
                'dias' => 'required|array' // Sin tilde
            ]);

            // Proporcionar valores por defecto para encabezado
            $encabezado = $request->input('encabezado', []);

            // Fusionar con valores por defecto
            $encabezado = array_merge([
                'sede' => 'SEDE CENTRAL (UPTYAB)',
                'trayecto' => 'III',
                'trimestre' => 'II',
                'seccion' => '753501',
                'lapso' => '2025-4',
                'laboratorios' => [
                    'LABORATORIO SIMON BOLIVAR: ELECTIVA III',
                    'LABORATORIO HUGO CHAVEZ: ING SW II',
                    'LABORATORIO HUGO CHAVEZ: MODELADO BD'
                ]
            ], $encabezado);

            $data = [
                'encabezado' => $encabezado,
                'bloques' => $request->input('bloques', []),
                'eventos' => $request->input('eventos', []),
                'dias' => $request->input('dias', [])
            ];

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
