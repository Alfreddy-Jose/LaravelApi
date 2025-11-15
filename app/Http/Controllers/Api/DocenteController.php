<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocenteRequest;
use App\Models\Clase;
use App\Models\CondicionContrato;
use App\Models\Docente;
use App\Models\Persona;
use App\Models\Pnf;
use App\Models\UnidadCurricular;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los docentes con sus relaciones
        $docentes = Docente::with(['persona', 'pnf', 'unidades_curriculares:id,nombre', 'condicionContrato:id,docente_id,fecha_inicio,fecha_fin,dedicacion,tipo'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Retornar la lista de docentes
        return response()->json($docentes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocenteRequest $request)
    {
        $docente = new Docente();
        $docente->persona_id = $request->persona_id;
        $docente->pnf_id = $request->pnf_id;
        $docente->categoria = $request->categoria;
        $docente->horas_dedicacion = $request->horas_dedicacion;

        if ($docente->save()) {
            $condicion_contrato = new CondicionContrato();
            $condicion_contrato->fecha_inicio = $request->fecha_inicio;
            $condicion_contrato->fecha_fin = $request->fecha_fin;
            $condicion_contrato->dedicacion = $request->dedicacion;
            $condicion_contrato->tipo = $request->tipo;
            $condicion_contrato->docente_id = $docente->id;
            $condicion_contrato->save();

            // Asignar unidades curriculares
            if ($request->has('unidad_curricular_id')) {
                $docente->unidades_curriculares()->sync($request->unidad_curricular_id);
            }

            return response()->json(["message" => "Docente Registrado"], 200);
        }

        return response()->json(["message" => "Error al Registrar Docente"], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show($docente)
    {
        // Obtener el docente por ID con sus relaciones
        $docente = Docente::with(['persona', 'pnf:id,nombre', 'unidades_curriculares:id,nombre', 'condicionContrato'])
            ->findOrFail($docente);

        // Retornar el docente
        return response()->json($docente, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $docente = Docente::find($id);

        // Si dedicacion es tiempo completo, horas dedicacion debe ser 18 sino 12
        if ($request->dedicacion == 'TIEMPO COMPLETO') {
            $request->merge(['horas_dedicacion' => 18]);
        } else {
            $request->merge(['horas_dedicacion' => 12]);
        }

        $updateData = [
            'pnf_id' => $request->pnf_id,
            'categoria' => $request->categoria,
            'horas_dedicacion' => $request->horas_dedicacion
        ];

        // Actualizar el Docente
        $docente->update($updateData);

        // Actualizar persona relacionada
        $docente->condicionContrato()->where('docente_id', $docente->id)->update([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'dedicacion' => $request->dedicacion,
            'tipo' => $request->tipo,
        ]);

        // Actualizar unidades curriculares
        if ($request->has('unidad_curricular_id')) {
            $docente->unidades_curriculares()->sync($request->unidad_curricular_id);
        }

        return response()->json(["message" => "Docente Editado"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {
        $docente->delete();

        return response()->json(['message' => 'Docente eliminado'], 200);
    }

    public function getDataSelect()
    {
        $docentesIds = Persona::where('tipo_persona', 'DOCENTE')->select('id', 'cedula_persona', 'nombre', 'apellido')->get();
        $docentes = Persona::where('tipo_persona', 'DOCENTE')
            ->whereDoesntHave('docente')
            ->get();
        $unidadesCurriculares = UnidadCurricular::select('id', 'nombre')->get();
        $pnf = Pnf::select('id', 'nombre')->get();

        $docentesEdit = $docentesIds->map(function ($persona) {
            return [
                'id' => $persona->id,
                'nombre' => $persona->nombre . ' ' . $persona->apellido . ' - ' . $persona->cedula_persona,
            ];
        });
        $docentes = $docentes->map(function ($docente) {
            return [
                'id' => $docente->id,
                'nombre' => $docente->nombre . ' ' . $docente->apellido . ' - ' . $docente->cedula_persona,
            ];
        });

        return response()->json([
            'docentes' => $docentes,
            'docentesEdit' => $docentesEdit,
            'unidadesCurriculares' => $unidadesCurriculares,
            'pnf' => $pnf
        ], 200);
    }

    // Agrega este método en tu DocenteController
    public function getDocentesByFilters(Request $request)
    {
        // Validar los parámetros de entrada
        $request->validate([
            'pnf_id' => 'nullable|integer|exists:pnfs,id',
            'unidad_curricular_id' => 'nullable|integer|exists:unidad_curriculars,id'
        ]);

        // Construir la consulta base
        $query = Docente::with(['persona', 'pnf', 'condicionContrato'])
            ->when($request->pnf_id, function ($q) use ($request) {
                $q->where('pnf_id', $request->pnf_id);
            })
            ->when($request->unidad_curricular_id, function ($q) use ($request) {
                $q->whereHas('unidades_curriculares', function ($subQuery) use ($request) {
                    $subQuery->where('unidad_curriculars.id', $request->unidad_curricular_id);
                });
            });

        // Obtener y formatear los resultados
        $docentes = $query->get()->map(function ($docente) {
            return [
                'id' => $docente->id,
                'categoria' => $docente->categoria,
                'horas_dedicacion' => $docente->horas_dedicacion,
                'pnf' => [
                    'id' => $docente->pnf_id,
                    'nombre' => $docente->pnf->nombre ?? null
                ],
                'persona' => [
                    'cedula' => $docente->persona->cedula_persona ?? null,
                    'nombre_completo' => ($docente->persona->nombre ?? '') . ' ' . ($docente->persona->apellido ?? ''),
                    'email' => $docente->persona->email ?? null,
                    'telefono' => $docente->persona->telefono ?? null
                ],
                'condicion_contrato' => $docente->condicionContrato
            ];
        });


        return response()->json($docentes);
    }



    public function actualizarHorasDedicacion(Request $request, $id)
    {
        $docente = Docente::findOrFail($id);

        // Recibe la diferencia de horas por query param
        $diferencia = intval($request->query('horas_dedicacion', 0));

        // Suma o resta según el valor recibido
        $docente->horas_dedicacion += $diferencia;

        // Opcional: asegúrate de que no sea negativo
        if ($docente->horas_dedicacion < 0) {
            $docente->horas_dedicacion = 0;
        }

        $docente->save();

        return response()->json([
            'success' => true,
            'horas_disponibles' => $docente->horas_dedicacion,
        ]);
    }

    public function conClases()
    {
        $docentesPorTrimestre = DB::table('clases')
            ->join('docentes', 'clases.docente_id', '=', 'docentes.id')
            ->join('personas', 'docentes.persona_id', '=', 'personas.id')
            ->join('horarios', 'clases.horario_id', '=', 'horarios.id')
            ->join('trimestres', 'horarios.trimestre_id', '=', 'trimestres.id')
            ->select(
                'docentes.id as docente_id',
                'docentes.categoria',
                'docentes.horas_dedicacion',
                'personas.nombre',
                'personas.apellido',
                'personas.cedula_persona',
                'trimestres.id as trimestre_id',
                'trimestres.nombre as trimestre_nombre',
                'trimestres.numero_relativo',
                DB::raw('COUNT(clases.id) as clases_count')
            )
            ->groupBy(
                'docentes.id',
                'docentes.categoria',
                'docentes.horas_dedicacion',
                'personas.nombre',
                'personas.apellido',
                'personas.cedula_persona',
                'trimestres.id',
                'trimestres.nombre',
                'trimestres.numero_relativo'
            )
            ->get()
            ->map(function ($item, $index) {
            // Aplicamos la misma lógica del accessor
            $romanos = [1 => 'I', 2 => 'II', 3 => 'III'];
            $nombreRelativo = $romanos[$item->numero_relativo] ?? $item->trimestre_nombre;

                return [
                    'id' => $index + 1, // ID secuencial para la tabla
                    'docente_id' => $item->docente_id,
                    'categoria' => $item->categoria,
                    'horas_dedicacion' => $item->horas_dedicacion,
                    'nombre_completo' => $item->nombre . ' ' . $item->apellido,
                    'cedula' => $item->cedula_persona,
                    'trimestre_id' => $item->trimestre_id,
                    'trimestre_nombre' => $nombreRelativo, // Usamos el nombre relativo
                    'trimestre_valor_real' => $item->trimestre_nombre, // Mantenemos el valor real
                    'clases_count' => $item->clases_count
                ];
            });

        return response()->json($docentesPorTrimestre);
    }
}
