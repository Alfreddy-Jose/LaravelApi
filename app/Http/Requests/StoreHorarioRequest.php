<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHorarioRequest extends FormRequest
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
            'trimestre_id' => 'required|exists:trimestres,id',
            'seccion_id'   => 'required|exists:seccions,id',
            'nombre'       => 'nullable|string|max:150',
        ];
    }

    public function messages()
    {
        return [
            'trimestre_id.required' => 'Este campo es obligatorio',
            'seccion_id.required'   => 'Este campo es obligatorio',
        ];
    }
}
