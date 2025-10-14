<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAulaRequest extends FormRequest
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
            "sede_id" => "required|exists:sedes,id"
        ];
    }

    public function attributes()
    {
        return [
            "nombre_aula" => "nombre de aula",
            "nro_aula" => "numero de aula",
            "sede_id" => "sede"
        ];
    }
}
