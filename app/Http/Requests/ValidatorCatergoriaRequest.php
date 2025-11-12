<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatorCatergoriaRequest extends FormRequest
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
            'nombre' => ['Require', 'string', 'max:255'],
            'descripcion' => ['Require', 'string'],
        ];
    }
    public function messages():array
    {
        return[
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto .',
            'nombre.required' => 'el nombre no debe exeder los 255 caracteres.',
    
            'descripcion' => 'El nombre del producto es obligatorio.', 
    
    
        ];
    }
}
