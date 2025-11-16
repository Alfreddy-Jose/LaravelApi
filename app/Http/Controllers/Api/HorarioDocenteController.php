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
    public function generarPDFDocente($docenteId, $trimestreId = null)
    {
        try {
            // Buscar docente con su persona
            $docente = Docente::with('persona')->findOrFail($docenteId);

            // Traer bloques y días desde la BD
            $bloques = BloquesTurno::ordenados()->get()->toArray();

            // Crear un mapa de ID a posición secuencial
            $mapaIdAPosicion = [];
            foreach ($bloques as $index => $bloque) {
                $mapaIdAPosicion[$bloque['id']] = $index + 1; // Posición comienza en 1
            }

            Log::info("Mapa ID a Posición:", $mapaIdAPosicion);

            $diasNormalizado = ["LUNES", "MARTES", "MIÉRCOLES", "JUEVES", "VIERNES", "SÁBADO"];

            $mapeoDias = [
                // LUNES
                'lunes' => 'LUNES',
                'LUNES' => 'LUNES',

                // MARTES
                'martes' => 'MARTES',
                'MARTES' => 'MARTES',

                // MIÉRCOLES (con variaciones)
                'miércoles' => 'MIÉRCOLES',
                'miercoles' => 'MIÉRCOLES',
                'MIÉRCOLES' => 'MIÉRCOLES',
                'MIERCOLES' => 'MIÉRCOLES',
                'miercole' => 'MIÉRCOLES',
                'MIERCOLE' => 'MIÉRCOLES',

                // JUEVES
                'jueves' => 'JUEVES',
                'JUEVES' => 'JUEVES',

                // VIERNES
                'viernes' => 'VIERNES',
                'VIERNES' => 'VIERNES',

                // SÁBADO (con variaciones)
                'sábado' => 'SÁBADO',
                'sabado' => 'SÁBADO',
                'SÁBADO' => 'SÁBADO',
                'SABADO' => 'SÁBADO'
            ];

            // Traer las clases del docente, filtrando por trimestre si se especifica
            $clasesQuery = Clase::with([
                'unidadCurricular',
                'espacio',
                'pnf',
                'trayecto',
                'trimestre',
                'horario.seccion'
            ])
                ->where('docente_id', $docenteId);

            // Filtrar por trimestre si se proporciona
            if ($trimestreId) {
                $clasesQuery->whereHas('horario', function ($query) use ($trimestreId) {
                    $query->where('trimestre_id', $trimestreId);
                });
            }

            $clases = $clasesQuery->get();

            // Obtener información del trimestre seleccionado
            $trimestreSeleccionado = null;
            if ($trimestreId) {
                $trimestreSeleccionado = \App\Models\Trimestre::find($trimestreId);
            }

            // Procesar las clases a eventos
            // Procesar las clases a eventos
            $eventosProcesados = $clases->map(function ($clase) use ($mapeoDias, $mapaIdAPosicion) {
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

                return [
                    'dia' => $diaNormalizado,
                    'bloque_inicio' => $posicion_inicio,
                    'bloque_fin' => $posicion_fin,
                    'materia' => $clase->unidadCurricular->nombre,
                    'aula' => $clase->espacio->nombre_aula ?? '',
                    'seccion' => $clase->horario->seccion->nombre ?? '',
                    'color' => '#e3f2fd',
                ];
            })->filter()->values()->toArray(); // Filtrar nulls y reindexar

            // Encabezado con info del docente
            $primerClase = $clases->first();
            $encabezado = [
                'docente' => $docente->persona->nombre . ' ' . $docente->persona->apellido,
                'cedula' => $docente->persona->cedula_persona ?? 'N/A',
                'pnf' => $primerClase->pnf->nombre ?? 'N/A',
                'pnf_abreviado' => $primerClase->pnf->abreviado ?? 'N/A',
                'trayecto' => $primerClase->trayecto->nombre ?? 'N/A',
                'trimestre' => $trimestreSeleccionado ? $trimestreSeleccionado->nombre_relativo : ($primerClase->trimestre->nombre_relativo ?? 'N/A'),
                'seccion' => $primerClase->horario->seccion->nombre ?? 'N/A',
                'lapso' => $primerClase->horario->seccion->lapso->nombre_lapso ?? 'N/A',
            ];

            // Preparar datos para la vista
            $data = [
                'docente' => $docente,
                'bloques' => $bloques,
                'dias' => $diasNormalizado,
                'eventos' => $eventosProcesados,
                'encabezado' => $encabezado,
            ];

            Log::info('data: ' . json_encode($data));
            // Generar PDF
            $pdf = Pdf::loadView('pdf.horario_docente', $data)
                ->setPaper('a4', 'landscape')
                ->setOption('enable_html5_parser', true);

            // Nombre del archivo personalizado
            $nombreArchivo = "horario_docente_" . $docente->persona->nombre . "_" . $docente->persona->apellido;
            if ($trimestreSeleccionado) {
                $nombreArchivo .= "_trimestre_" . $trimestreSeleccionado->nombre;
            }
            $nombreArchivo .= ".pdf";

            return $pdf->stream($nombreArchivo, ['Attachment' => false]);
        } catch (\Exception $e) {
            Log::error("Error generando PDF del docente: " . $e->getMessage());
            return response()->json([
                'error' => 'Error generando PDF del docente',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
