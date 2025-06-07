<?php

namespace App\Services\Api\Weather;

use App\Contracts\Api\Weather\WeatherSearchRecorderInterface;
use App\Models\Weather\City;
use App\Models\Weather\Country;
use App\Models\Weather\WeatherSearch;
use Illuminate\Support\Facades\Auth;

class WeatherSearchRecorder implements WeatherSearchRecorderInterface
{
    public function record(array $weatherData, string $cityName, string $countryName): City
    {
        $country = Country::firstOrCreate(['name' => $countryName]);

        $city = City::firstOrCreate(
            ['name' => $cityName, 'country_id' => $country->id],
            [
                'latitude' => $weatherData['location']['lat'] ?? null,
                'longitude' => $weatherData['location']['lon'] ?? null
            ]
        );

        $user = Auth::user();

        if ($user) {
            WeatherSearch::create([
                'user_id' => $user->id,
                'city_id' => $city->id,
                'weather_data' => $weatherData
            ]);
        }

        return $city;
    }
}