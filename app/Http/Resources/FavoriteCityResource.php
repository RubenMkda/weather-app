<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteCityResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="FavoriteCityResource",
     *     type="object",
     *     title="Ciudad Favorita",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="city_id", type="integer", example=123),
     *     @OA\Property(
     *         property="city",
     *         type="object",
     *         @OA\Property(property="name", type="string", example="Madrid"),
     *         @OA\Property(property="latitude", type="number", format="float", example=40.4168),
     *         @OA\Property(property="longitude", type="number", format="float", example=-3.7038)
     *     ),
     *     @OA\Property(property="user_id", type="integer", example=10),
     *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-07T12:00:00Z")
     * )
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
