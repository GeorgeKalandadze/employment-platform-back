<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'name'                  => ['required', 'min:3'],
           'email'                 => ['required', 'email'],
           'password'              => ['required', 'min:8', 'max:15', 'confirmed'],
           'password_confirmation' => ['required'],
        ];
    }
}
