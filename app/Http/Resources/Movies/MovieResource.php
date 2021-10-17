<?php

namespace App\Http\Resources\Movies;

use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\Image\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'video' => $this->video,
            'image' => ImageResource::make($this->whenLoaded('image')),
            'paid' => $this->paid ? 'Paid Movie' : 'Free Movie'
        ];
    }
}
