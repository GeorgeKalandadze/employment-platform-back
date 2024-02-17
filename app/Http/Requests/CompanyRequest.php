<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
<<<<<<< HEAD
            'name' => 'required|string|max:255|unique:companies,name,',
=======
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
>>>>>>> ac6190267f5cefacffd91944c5c774a0427e8b0c
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'nullable|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|string|max:255',
            'description' => 'required|string',
        ];
    }
}