<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Pnf;
use App\Models\Sede;
use App\Models\Trayecto;
use App\Models\Trimestre;
use App\Models\UnidadCurricular;
use Illuminate\Http\Request;

class HorarioSelectsController extends Controller
{
    /**
     * Obtener todas las sedes
     */
    public function getSedes()
    {
        $sedes = Sede::orderBy('nombre_sede')->get(['id', 'nombre_sede']);
        return response()->json($sedes);
    }

    /**
     * Obtener Pnfs basados en sede seleccionada
     */
    public function getPnfs($sede)
    {
        $sede = Sede::findOrFail($sede);
        $pnfs = $sede->pnfs()->orderBy('nombre')->get(['pnfs.id', 'pnfs.nombre']);

        return response()->json($pnfs);
    }

    /**
     * Obtener todos los trayectos
     */
    public function getTrayectos()
    {
        $trayectos = Trayecto::orderBy('nombre')->get(['id', 'nombre']);
        return response()->json($trayectos);
    }

    /**
     * Obtener trimestres basados en trayecto seleccionado
     */
    public function getTrimestres($trayectoId)
    {
        $trimestres = Trimestre::where('trayecto_id', $trayectoId)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);
        
        return response()->json($trimestres);
    }

    /**
     * Obtener unidades curriculares basadas en trimestre seleccionado
     */
    public function getUnidadesCurriculares($trimestreId)
    {
        $unidadesCurriculares = UnidadCurricular::where('trimestre_id', $trimestreId)
            ->orderBy('nombre')
            ->get(['id', 'nombre as text']);

        return response()->json($unidadesCurriculares);
    }

    /**
     * Obtener docentes basados en unidad curricular seleccionada
    */

    public function getDocentes($unidadCurriclarId)
    {
        $unidadesCurriculares = UnidadCurricular::findOrFail($unidadCurriclarId);

        $docentes = $unidadesCurriculares->docentes()
            ->orderBy('id', 'asc')->get();
        
        return response()->json($docentes);
    }

    /**
     * Obtener espacios basadas en sede seleccionada
    */

    public function getEspacios($sedeId)
    {
        $sede = Sede::findOrFail($sedeId);

        $aulas = $sede->espacios()
            ->orderBy('nombre_aula')
            ->get(['id', 'nombre_aula']);

        return response()->json($aulas);
    }
}
