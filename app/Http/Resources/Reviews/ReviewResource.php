<?php

namespace App\Http\Resources\Reviews;

use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\Movies\MovieResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'review' => $this->review,
            'rate' => $this->rate,
            'movie' => MovieResource::make($this->whenLoaded('movie')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'approved' => (bool)$this->approved,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
