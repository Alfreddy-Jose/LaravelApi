<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaboratoriosRequest extends FormRequest
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
            "codigo" => "required|unique:espacios,codigo",
            "nombre_aula" => "required|unique:espacios,nombre_aula",
            "etapa" => "required|string",
            "abreviado_lab" => "required|string",
            "equipos" => "required|numeric",
            "sede_id" => "required|exists:sedes,id"
        ];
    }

    public function attributes()
    {
        return [
            "nombre_aula" => "nombre de laboratorio",
            "abreviado_lab" => "abreviado laboratorio",
            "sede_id" => "sede"
        ];
    }
}
