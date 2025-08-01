<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeccionRequest;
use App\Http\Requests\UpdateSeccionRequest;
use App\Models\LapsoAcademico;
use App\Models\Matricula;
use App\Models\Pnf;
use App\Models\Seccion;
use App\Models\Sede;
use App\Models\Trayecto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /*         $secciones = Seccion::with([
            'pnf:id,nombre',
            'matricula:id,nombre',
            'trayecto:id,nombre',
            'sede:id,nombre_sede',
            'lapso:id,nombre_lapso,ano'
        ])->select('id', 'pnf_id', 'matricula_id', 'trayecto_id', 'sede_id', 'lapso_id', 'nombre', 'numero_seccion')->get();

        return response()->json($secciones); */
        $query = Seccion::query();

        // Filtrar por lapso
        if ($request->lapso) {
            $query->where('lapso_id', $request->lapso);
        }
        // Filtrar por sede
        if ($request->sede) {
            $query->where('sede_id', $request->sede);
        }
        // Filtrar por pnf
        if ($request->pnf) {
            $query->where('pnf_id', $request->pnf);
        }
        // Filtrar por trayecto
        if ($request->trayecto) {
            $query->where('trayecto_id', $request->trayecto);
        }
        // Filtrar por tipo de matrícula
        if ($request->matricula) {
            $query->where('matricula_id', $request->matricula);
        }

        // Relaciona los datos para la tabla
        $secciones = $query->with(['pnf', 'matricula', 'trayecto', 'sede', 'lapso'])->get();

        return response()->json($secciones);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeccionRequest $request)
    {
        // Buscar los datos relacionados usando los IDs recibidos
        $pnf = Pnf::findOrFail($request->pnf_id); // Para obtener el id (ya lo tienes)
        $matricula = Matricula::findOrFail($request->matricula_id); // Para obtener el numero
        $trayecto = Trayecto::findOrFail($request->trayecto_id); // Para obtener el nombre
        $sede = Sede::findOrFail($request->sede_id); // Para obtener el nro_sede

        // Construir el nombre de la sección
        $nombre = $pnf->codigo . '' . $matricula->numero . '' . $trayecto->nombre . '' . $sede->nro_sede . '' . $request->numero_seccion;

        // Crear la sección
        $seccion = new Seccion();
        $seccion->pnf_id = $request->pnf_id;
        $seccion->matricula_id = $request->matricula_id;
        $seccion->trayecto_id = $request->trayecto_id;
        $seccion->sede_id = $request->sede_id;
        $seccion->lapso_id = $request->lapso_id;
        $seccion->numero_seccion = $request->numero_seccion;
        $seccion->nombre = $nombre;
        $seccion->save();

        return response()->json(['message' => 'Sección creada'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Seccion $seccion) {
        return response()->json($seccion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeccionRequest $request, Seccion $seccion)
    {
        $pnf = Pnf::findOrFail($request->pnf_id);
        $matricula = Matricula::findOrFail($request->matricula_id);
        $trayecto = Trayecto::findOrFail($request->trayecto_id);
        $sede = Sede::findOrFail($request->sede_id);

        // Construir el nombre de la sección
        $nombre = $pnf->codigo . '' . $matricula->numero . '' . $trayecto->nombre . '' . $sede->nro_sede . '' . $request->numero_seccion;

        // Crear la sección
        $seccion = new Seccion();
        $seccion->pnf_id = $request->pnf_id;
        $seccion->matricula_id = $request->matricula_id;
        $seccion->trayecto_id = $request->trayecto_id;
        $seccion->sede_id = $request->sede_id;
        $seccion->lapso_id = $request->lapso_id;
        $seccion->numero_seccion = $request->numero_seccion;
        $seccion->nombre = $nombre;
        $seccion->save();

        return response()->json(["message" => "Seccion Editada"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seccion $seccion)
    {
        // eliminar la sección
        $seccion->delete();

        // retornar una respuesta de éxito
        return response()->json(['message' => 'Sección eliminada'], 200);
    }

    public function getDataSelect()
    {
        $pnfs = Pnf::select('id', 'nombre')->get();
        $trayectos = Trayecto::select('id', 'nombre')->get();
        $tipo_matricula = Matricula::select('id', 'nombre', 'numero')->get();
        $sedes = Sede::select('id', 'nro_sede', 'nombre_sede')->get();
        $lapsos = LapsoAcademico::select('id', 'nombre_lapso', 'ano')->get();

        return response()->json([
            "pnfs" => $pnfs,
            "trayectos" => $trayectos,
            "tipo_matricula" => $tipo_matricula,
            "sedes" => $sedes,
            "lapsos" => $lapsos
        ]);
    }

    public function pdf(Request $request)
    {
        // Puedes recibir parámetros para filtrar igual que en index
        $query = Seccion::query();

        if ($request->lapso) {
            $query->where('lapso_id', $request->lapso);
        }
        if ($request->sede) {
            $query->where('sede_id', $request->sede);
        }
        if ($request->pnf) {
            $query->where('pnf_id', $request->pnf);
        }
        if ($request->trayecto) {
            $query->where('trayecto_id', $request->trayecto);
        }
        if ($request->matricula) {
            $query->where('matricula_id', $request->matricula);
        }

        $secciones = $query->with(['pnf', 'matricula', 'trayecto', 'sede', 'lapso'])->get();

        // Renderiza una vista blade para el PDF
        $pdf = Pdf::loadView('pdf.secciones', compact('secciones'));

        // Descarga el PDF
        return $pdf->download('secciones.pdf');
    }
}
