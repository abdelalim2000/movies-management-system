<?php

namespace App\Http\Resources\Categories;

use App\Http\Resources\Movies\MovieResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'sup_categories' => CategoryResource::collection($this->whenLoaded('children')),
            'movies' => MovieResource::collection($this->whenLoaded('movies')),
        ];
    }
}
