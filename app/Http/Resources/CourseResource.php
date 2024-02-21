<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $creatorInfo = $this->courseable_type === 'App\\Models\\Company' ?
            [
                'name' => $this->courseable->name,
                'image' => $this->courseable->logo,
            ] :
            [
                'name' => $this->courseable->username,
                'image' => $this->courseable->avatar_image,
            ];

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'start_date' => $this->start_date,
            'sub_category' => $this->subCategory,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'creator' => $creatorInfo,
        ];

    }
}
