<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BloquesTurno;
use App\Models\Clase;
use App\Models\Docente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HorarioDocenteController extends Controller
{
    public function generarPDFDocente($docenteId)
    {
        try {
            // Buscar docente con su persona
            $docente = Docente::with('persona')->findOrFail($docenteId);

            // Traer bloques y días desde la BD
            $bloques = BloquesTurno::orderBy('id')->get(['id', 'rango'])->toArray();
            $dias = ["LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO"];

            // Traer todas las clases de ese docente
            $clases = Clase::with([
                'unidadCurricular',
                'espacio',
                'pnf',
                'trayecto',
                'trimestre',
                'horario.seccion'
            ])
                ->where('docente_id', $docenteId)
                ->get();

            // Procesar las clases a eventos
            $eventosProcesados = $clases->map(function ($clase) {
                $bloque_inicio = $clase->bloque_id;
                $bloque_fin = $bloque_inicio + $clase->duracion - 1;

                return [
                    'dia' => $clase->dia,
                    'bloque_inicio' => $bloque_inicio,
                    'bloque_fin' => $bloque_fin,
                    'materia' => $clase->unidadCurricular->nombre,
                    'aula' => $clase->espacio->nombre_aula ?? '',
                    'seccion' => $clase->horario->seccion->nombre ?? '',
                    'color' => '#e3f2fd',
                ];
            })->toArray();

            // Encabezado con info del docente
            $encabezado = [
                'docente' => $docente->persona->nombre . ' ' . $docente->persona->apellido,
                'cedula' => $docente->persona->cedula ?? '',
                'pnf' => $clases->first()->pnf->nombre ?? '',
                'trayecto' => $clases->first()->trayecto->nombre ?? '',
                'trimestre' => $clases->first()->trimestre->nombre ?? '',
                'seccion' => $clases->first()->horario->seccion->nombre ?? '',
                'lapso' => $clases->first()->horario->seccion->lapso->nombre_lapso ?? '',
            ];

            // Preparar datos para la vista
            $data = [
                'docente' => $docente,
                'bloques' => $bloques,
                'dias' => $dias,
                'eventos' => $eventosProcesados,
                'encabezado' => $encabezado,
            ];

            // Generar PDF
            $pdf = Pdf::loadView('pdf.horario_docente', $data)
                ->setPaper('a4', 'landscape')
                ->setOption('enable_html5_parser', true);
            return $pdf->stream("horario_docente_" . $docente->persona->nombre . "_" . $docente->persona->apellido . ".pdf", ['Attachment' => false]);
        } catch (\Exception $e) {
            Log::error("Error generando PDF del docente: " . $e->getMessage());
            return response()->json([
                'error' => 'Error generando PDF del docente',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
