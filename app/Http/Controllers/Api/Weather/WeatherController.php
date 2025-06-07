<?php

namespace App\Http\Controllers\Api\Weather;

use App\Contracts\Api\Weather\WeatherSearchRecorderInterface;
use App\Contracts\Api\Weather\WeatherServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Weather\SearchWeatherRequest;
use App\Http\Resources\WeatherResource;

class WeatherController extends Controller  
{
    public function __construct(private WeatherServiceInterface $weatherService, private WeatherSearchRecorderInterface $searchRecorder) 
    {
    }

    public function search(SearchWeatherRequest $request)
    {
        $cityName = $request->input('city');

        $weatherData = $this->weatherService->getWeather($cityName);
        $countryName = $weatherData['location']['country'];
        
        $this->searchRecorder->record($weatherData, $cityName, $countryName);

        return new WeatherResource(collect($weatherData));
    }
}
