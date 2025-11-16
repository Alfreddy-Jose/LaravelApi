<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAulaRequest extends FormRequest
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
            "etapa" => "required|string",
            "nro_aula" => "required|numeric",
            "sede_id" => "required|exists:sedes,id" ,
            "nombre_aula" => "required|unique:espacios,nombre_aula"
        ];
    }

    public function attributes()
    {
        return [
            "etapa" => "etapa",
            "nro_aula" => "numero de aula",
            "sede_id" => "sede",
            "nombre_aula" => "nombre aula"
        ];
    }
}
