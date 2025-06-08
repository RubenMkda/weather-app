<?php

namespace App\Http\Controllers\Api\Weather;

use App\Contracts\Api\Weather\WeatherSearchRecorderInterface;
use App\Contracts\Api\Weather\WeatherServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Weather\RecentSearchesRequest;
use App\Http\Requests\Weather\SearchWeatherRequest;
use App\Http\Resources\WeatherResource;
use App\Http\Resources\WeatherSearchResource;
use App\Services\Api\Weather\UserWeatherSearchService;
use Illuminate\Http\Request;

class WeatherController extends Controller  
{
    public function __construct(
        private WeatherServiceInterface $weatherService,
        private WeatherSearchRecorderInterface $searchRecorder,
        private UserWeatherSearchService $userWeatherSearchService
    ) {
    }

    public function search(SearchWeatherRequest $request)
    {
        $cityName = $request->input('city');

        $user = $request->user();
        $language = $user->language->code ?? $request->header('Accept-Language', 'en');

        $weatherData = $this->weatherService->getWeather($cityName, $language);

        $countryName = $weatherData['location']['country'];
        $this->searchRecorder->record($weatherData, $cityName, $countryName);

        return new WeatherResource(collect($weatherData));
    }

    public function recentSearches(RecentSearchesRequest $request)
    {
        $user = $request->user();

        $searches = $this->userWeatherSearchService->getRecentSearches($user);

        return WeatherSearchResource::collection($searches);
    }
}
