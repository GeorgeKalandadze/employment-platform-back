<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVacancyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sub_category_id' => ['nullable'],
            'title' => ['required'],
            'description' => ['required'],
            'salary' => ['nullable'],
            'job_type_id' => ['required'],
            'experience_years' => ['nullable'],
            'vacancyable_id' => ['required'],
            'vacancyable_type' => ['required'],
        ];
    }
}
