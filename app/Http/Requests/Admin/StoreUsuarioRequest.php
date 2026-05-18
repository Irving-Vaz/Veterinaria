<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:administrador,veterinario',
            'nombre_completo' => 'required_if:rol,veterinario|nullable|string|max:255',
            'especialidad' => 'required_if:rol,veterinario|nullable|string|max:255',
            'cedula_profesional' => 'required_if:rol,veterinario|nullable|string|max:255',
            'foto_firma' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre de usuario',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'rol' => 'rol del sistema',
            'nombre_completo' => 'nombre completo',
            'especialidad' => 'especialidad',
            'cedula_profesional' => 'cédula profesional',
            'foto_firma' => 'firma digital',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'required_if' => 'El campo :attribute es obligatorio cuando el rol es veterinario.',
            'string' => 'El campo :attribute debe ser texto válido.',
            'max' => 'El campo :attribute no debe superar los :max caracteres/kilobytes.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'email' => 'El campo :attribute debe ser una dirección de correo válida.',
            'unique' => 'Este :attribute ya se encuentra registrado.',
            'confirmed' => 'La confirmación de la contraseña no coincide.',
            'in' => 'El :attribute seleccionado no es válido.',
            'image' => 'El archivo seleccionado debe ser una imagen.',
            'mimes' => 'El archivo de :attribute debe ser de tipo: :values.',
        ];
    }
}
