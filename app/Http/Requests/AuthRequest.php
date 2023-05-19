<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|min:2',
            'password' => 'required|min:5',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required'  => 'username must be filled',
            'username.min'       => 'minimum username is 2 characters',
            'password.required'  => 'password must be filled',
            'password.min'       => 'minimum password is 5 characters',
        ];
    }
}
