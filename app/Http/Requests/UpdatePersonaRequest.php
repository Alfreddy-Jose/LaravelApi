<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonaRequest extends FormRequest
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
            "cedula_persona" => "required|numeric|unique:personas,cedula_persona" . ',' . $this->route('persona')->id,
            "nombre" => "required|string",
            "apellido" => "required|string",
            "email" => "email|unique:personas,email",
            "direccion" => "max:255",
            "telefono" => "numeric|unique:personas,telefono"
        ];
    }

    public function messages()
    {
        return [
            "cedula_persona.unique" => "La cédula ingresada ya se encuentra registrada",
        ];
    }
}
