<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['min:3', 'max:15', 'unique:users'],
            'avatar_image' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
}
