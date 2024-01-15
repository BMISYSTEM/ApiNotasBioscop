<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @return array {email,password,nombre}
 */
class login extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => ['required','email'],
            'password' => ['required'],
        ];
    }

    public function messages():array
    {
        return [
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no tiene el formato deseado',
        ];
    }
}
