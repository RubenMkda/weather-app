<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteCityResource extends JsonResource
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
            'city_id' => $this->city_id,
            'user_id' => $this->user_id,
            'city' => [
                'name' => $this->city->name,
                'latitude' => $this->city->latitude,
                'longitude' => $this->city->longitude,
            ],
            'created_at' => $this->created_at,
        ];
    }

}
