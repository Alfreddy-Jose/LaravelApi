<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePnfRequest extends FormRequest
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
            'id' => 'required|numeric|unique:pnfs,id',
            'nombre' => 'required|string',
            'abreviado' => 'required|string|min:4',
            'abreviado_coord' => 'required|string|min:3'
        ];
    }
}
