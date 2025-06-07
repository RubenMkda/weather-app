<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherSearchResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="WeatherSearchResource",
     *     type="object",
     *     description="Registro de búsqueda reciente del clima",
     *     @OA\Property(
     *         property="searched_at",
     *         type="string",
     *         format="date-time",
     *         example="2025-06-07T12:34:56"
     *     ),
     *     @OA\Property(
     *         property="weather_data",
     *         ref="#/components/schemas/WeatherDataResource"
     *     )
     * )
     * @OA\Schema(
     *     schema="WeatherDataResource",
     *     type="object",
     *     description="Datos meteorológicos relacionados con la búsqueda",
     *     @OA\Property(
     *         property="location",
     *         type="object",
     *         description="Información del lugar",
     *         @OA\Property(property="city", type="string", example="Madrid"),
     *         @OA\Property(property="country", type="string", example="Spain")
     *     ),
     *     @OA\Property(property="temperature", type="number", format="float", example=23.5),
     *     @OA\Property(property="condition", type="string", example="Sunny")
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'searched_at' => $this->searched_at->toDateTimeString(),
            'weather_data' => new WeatherDataResource($this->weather_data),
        ];    
    } 
}
