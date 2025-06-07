<?php

namespace App\Contracts\Api\Weather;

use App\Models\Weather\City;

interface WeatherSearchRecorderInterface
{
    public function record(array $weatherData, string $cityName, string $countryName): City;
}
