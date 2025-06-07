<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'city' => $this['location']['name'],
            'country' => $this['location']['country'],
            'local_time' => $this['location']['localtime'],
            'temperature_celsius' => $this['current']['temp_c'],
            'weather_condition' => $this['current']['condition']['text'],
            'wind_speed_kph' => $this['current']['wind_kph'],
            'humidity_percent' => $this['current']['humidity'],
        ];
    }
}
