<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTurnoRequest extends FormRequest
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
    public function rules()
    {
        return [
            'inicio' => [
                'required',
                'date_format:H:i', // Formato 24H (ej: 07:30)
                'regex:/^(0\d|1\d|2[0-3]):[0-5]\d$/', // Valida horas 00:00 a 23:59
            ],
            'final' => [
                'required',
                'date_format:H:i',
                'regex:/^(0\d|1\d|2[0-3]):[0-5]\d$/',
                'after:inicio', // Final debe ser mayor que inicio
            ],
            'nombre' => 'required|string|unique:turnos,nombre',
            'inicio_periodo' => 'required|in:AM,PM',
            'final_periodo' => 'required|in:AM,PM'
        ];
    }
    public function messages()
    {
        return [
            'inicio.date_format' => 'El campo inicio debe ser una hora válida en formato HH:MM (ej: 07:30).',
            'inicio.regex' => 'El campo inicio debe estar entre 00:00 y 23:59.',
            'final.date_format' => 'El campo final debe ser una hora válida en formato HH:MM (ej: 12:15).',
            'final.after' => 'La hora final debe ser mayor que la hora de inicio.',
        ];
    }
}
