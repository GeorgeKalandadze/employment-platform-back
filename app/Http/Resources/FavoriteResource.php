<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'favoritable' => $this->favoritable_type === 'App\Models\Course' ?
                [
                    'title' => $this->favoritable->title,
                    'description' => $this->favoritable->description,
                    'price' => $this->favoritable->price,
                    'start_date' => $this->favoritable->start_date,
                    'sub_category' => $this->favoritable->subCategory,
                ] :
                [
                    'title' => $this->favoritable->title,
                    'description' => $this->favoritable->description,
                    'salary' => $this->favoritable->salary,
                    'experience_years' => $this->favoritable->experience_years,
                    'sub_category' => $this->favoritable->subCategory,
                    'jobType' => $this->favoritable->jobType,
                ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
