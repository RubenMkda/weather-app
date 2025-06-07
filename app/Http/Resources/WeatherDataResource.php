<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): Array
    {
        return [
            'city' => $this['city'],
            'country' => $this['country'],
            'local_time' => $this['local_time'],
            'temperature_celsius' => $this['temperature_celsius'],
            'weather_condition' => $this['weather_condition'],
            'humidity_percent' => $this['humidity_percent'],
            'wind_speed_kph' => $this['wind_speed_kph'],
        ];
    }
}
