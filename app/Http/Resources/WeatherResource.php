<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
/**
 * @OA\Schema(
 *     schema="WeatherResource",
 *     type="object",
 *     description="Datos actuales del clima para una ciudad",
 *     @OA\Property(property="city", type="string", example="Madrid", description="Nombre de la ciudad"),
 *     @OA\Property(property="country", type="string", example="Spain", description="Nombre del país"),
 *     @OA\Property(property="local_time", type="string", example="2025-06-07 15:30", description="Hora local de la ciudad"),
 *     @OA\Property(property="temperature_celsius", type="number", format="float", example=23.4, description="Temperatura en grados Celsius"),
 *     @OA\Property(property="weather_condition", type="string", example="Sunny", description="Descripción del clima"),
 *     @OA\Property(property="wind_speed_kph", type="number", format="float", example=15.2, description="Velocidad del viento en kilómetros por hora"),
 *     @OA\Property(property="humidity_percent", type="integer", example=65, description="Porcentaje de humedad")
 * )
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
