<?php

namespace App\Http\Resources\Plans;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'duration_months' => $this->duration_months
        ];
    }
}
