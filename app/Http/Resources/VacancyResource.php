<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VacancyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $creatorInfo = $this->vacancyable_type === 'App\\Models\\Company' ?
            [
                'name' => $this->vacancyable->name,
                'image' => $this->vacancyable->logo,
                'address' => $this->vacancyable->address,
            ] :
            [
                'name' => $this->vacancyable->username,
                'image' => $this->vacancyable->avatar_image,
            ];

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'salary' => $this->salary,
            'experience_years' => $this->experience_years,
            'created_at' => $this->created_at,
            'sub_categories' => SubCategoryResource::make($this->subCategory),
            'jobType' => JobTypeResource::make($this->jobType),
            'creator' => $creatorInfo,
        ];
    }
}
