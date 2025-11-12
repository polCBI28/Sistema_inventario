<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatorProveedorRequest extends FormRequest
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
             'ruc' => ['required', 'string', 'max:15', 'unique:proveedores,ruc,'],
            'razon_social' => ['required', 'string', 'max:255', 'min:3'],
            'direccion' => ['required', 'string', 'max:500'],
            'telefono' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:proveedores,email,'],
        ];
    }

    public function messages(): array
{
    return [
        // --- Reglas para RUC ---
        'ruc.required' => 'El campo RUC es obligatorio.',
        'ruc.string' => 'El RUC debe ser una cadena de texto.',
        'ruc.max' => 'El RUC no debe tener más de :max caracteres.',
        'ruc.unique' => 'El RUC ingresado ya está registrado a otro proveedor.',

        // --- Reglas para Razón Social ---
        'razon_social.required' => 'La Razón Social es obligatoria.',
        'razon_social.string' => 'La Razón Social debe ser una cadena de texto.',
        'razon_social.max' => 'La Razón Social no debe exceder los :max caracteres.',
        'razon_social.min' => 'La Razón Social debe tener al menos :min caracteres.',

        // --- Reglas para Dirección ---
        'direccion.required' => 'La Dirección es obligatoria.',
        'direccion.string' => 'La Dirección debe ser una cadena de texto.',
        'direccion.max' => 'La Dirección no debe exceder los :max caracteres.',

        // --- Reglas para Teléfono ---
        'telefono.required' => 'El número de Teléfono es obligatorio.',
        'telefono.string' => 'El Teléfono debe ser una cadena de texto.',
        'telefono.max' => 'El Teléfono no debe exceder los :max caracteres.',
        // Si usaste la regla 'regex', puedes añadir:
        // 'telefono.regex' => 'El formato del Teléfono no es válido.',

        // --- Reglas para Email ---
        'email.required' => 'El Email es obligatorio.',
        'email.string' => 'El Email debe ser una cadena de texto.',
        'email.email' => 'El Email debe tener un formato de correo electrónico válido.',
        'email.max' => 'El Email no debe exceder los :max caracteres.',
        'email.unique' => 'El Email ingresado ya está registrado a otro proveedor.',
    ];
}
}
