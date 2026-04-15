<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'correo'   => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'], // Opcional para "recordarme"
        ];
    }

    public function authorize(): bool
    {
        return true; // Permite que todos puedan hacer esta solicitud
    }
}
