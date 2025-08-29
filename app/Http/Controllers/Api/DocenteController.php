<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocenteRequest;
use App\Models\CondicionContrato;
use App\Models\Docente;
use App\Models\Persona;
use App\Models\Pnf;
use App\Models\UnidadCurricular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los docentes con sus relaciones
        $docentes = Docente::with(['persona', 'pnf', 'unidades_curriculares:id,nombre'])
            ->orderBy('created_at', 'desc')
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

        $updateData = [
            'pnf_id' => $request->pnf_id,
            'categoria' => $request->categoria
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
        $docentesIds = Persona::where('tipo_persona', 'DOCENTE')->select('id', 'cedula_persona', 'nombre')->get();
        $pnfs = Pnf::select('id', 'nombre')->get();
        $docentes = Persona::where('tipo_persona', 'DOCENTE')
            ->whereDoesntHave('docente')
            ->get();
        $unidadesCurriculares = UnidadCurricular::select('id', 'nombre')->get();

        $docentesEdit = $docentesIds->map(function ($persona) {
            return [
                'id' => $persona->id,
                'nombre' => $persona->nombre . ' - ' . $persona->cedula_persona,
            ];
        });
        $docentes = $docentes->map(function ($docente) {
            return [
                'id' => $docente->id,
                'nombre' => $docente->nombre . ' - ' . $docente->cedula_persona,
            ];
        });

        return response()->json([
            'pnf' => $pnfs,
            'docentes' => $docentes,
            'docentesEdit' => $docentesEdit,
            'unidadesCurriculares' => $unidadesCurriculares,
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
}
