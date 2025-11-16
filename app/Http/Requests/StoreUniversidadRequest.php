<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUniversidadRequest extends FormRequest
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
            'nombre_univ' => 'required|string|max:255',
            'abreviado_univ' => 'required|string|max:50',
            'rif_univ' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'nombre_univ' => 'nombre',
            'abreviado_univ' => 'nombre abreviatura',
            'rif_univ' => 'rif',
            'direccion' => 'dirección',
        ];
    }
}
