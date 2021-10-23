<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Image\ImageResource;
use App\Http\Resources\Reviews\ReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'image' => ImageResource::make($this->whenLoaded('image')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews'))
        ];
    }
}
