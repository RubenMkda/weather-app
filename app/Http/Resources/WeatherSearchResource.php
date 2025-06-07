<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'searched_at' => $this->searched_at->toDateTimeString(),
            'weather_data' => new WeatherDataResource($this->weather_data),
        ];    
    } 
}
