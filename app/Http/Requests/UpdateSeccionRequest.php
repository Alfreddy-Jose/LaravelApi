<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeccionRequest extends FormRequest
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
            "pnf_id" => "required|exists:pnfs,id",
            "matricula_id" => "required|exists:matriculas,id",
            "trayecto_id" => "required|exists:trayectos,id",
            "sede_id" => "required|exists:sedes,id",
        ];
    }

    public function attributes()
    {
        return [
            "pnf_id" => "pnf",
            "matricula_id" => "tipo matricula",
            "trayecto_id" => "trayecto",
            "sede_id" => "sede",
        ];
    }
}
