<?php

namespace App\Contracts\Api\Weather;

interface WeatherServiceInterface
{
    public function getWeather(string $city, string $language): array;
}
