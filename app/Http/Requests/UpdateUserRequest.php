<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|regex:/^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$/',
            'email' => 'required|email|unique:users,email,' . $this->route('user')->id,
            'rol' => 'required|exists:roles,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_avatar' => 'sometimes|boolean'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'El correo electrónico ya está registrado.',
            'avatarmimes' => 'El avatar debe ser una imagen de tipo: :values.',
            'avatar.max' => 'El avatar no debe ser mayor de :max kilobytes.',
            'avatar.nullable' => 'El avatar puede estar vacío.',
        ];
    }
}
