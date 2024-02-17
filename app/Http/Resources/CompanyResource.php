<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->logo,
            'address' => $this->address,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'website' => $this->website,
            'description' => $this->description,
            'user' => $this->user,
            'vacancies' => $this->vacancies,
            'courses' => $this->courses,
        ];
    }
}
