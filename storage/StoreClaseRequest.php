<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sede_id' => 'required|exists:sedes,id',
            'pnf_id' => 'required|exists:pnfs,id',
            'trayecto_id' => 'required|exists:trayectos,id',
            'trimestre_id' => 'required|exists:trimestres,id',
            'unidad_curricular_id' => 'required|exists:unidad_curriculars,id',
            'docente_id' => 'required|exists:docentes,id',
            'espacio_id' => 'required|exists:espacios,id',
            'bloque_id' => 'required|exists:bloques_turnos,id',
            'dia' => 'required|string|max:10',
            'duracion' => 'required|integer|min:1'
        ];
    }
}
