<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVacancyAsCompanyRequest extends FormRequest
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
            'company_id' => ['required'],
            'job_type_id' => ['required'],
            'title' => ['required'],
            'description' => ['required'],
            'salary' => ['nullable'],
            'experience_years' => ['nullable'],
        ];
    }
}
