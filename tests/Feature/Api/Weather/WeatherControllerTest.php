<?php

namespace Tests\Feature\Api\Weather;

use App\Contracts\Api\Weather\WeatherSearchRecorderInterface;
use App\Contracts\Api\Weather\WeatherServiceInterface;
use App\Http\Controllers\Api\Weather\WeatherController;
use App\Http\Resources\WeatherResource;
use App\Http\Resources\WeatherSearchResource;
use App\Http\Requests\Weather\RecentSearchesRequest;
use App\Http\Requests\Weather\SearchWeatherRequest;
use App\Models\User;
use App\Services\Api\Weather\UserWeatherSearchService;
use Mockery;
use Tests\TestCase;

class WeatherControllerTest extends TestCase
{
    public function test_search_returns_weather_resource_and_records_search()
    {
        $request = Mockery::mock(SearchWeatherRequest::class);
        $request->shouldReceive('input')->with('city')->andReturn('Madrid');

        $userMock = (object)[
            'language' => (object)['code' => 'es']
        ];
        $request->shouldReceive('user')->andReturn($userMock);
        $request->shouldReceive('header')->with('Accept-Language', 'en')->andReturn('en');

        $weatherData = [
            'location' => ['country' => 'Spain'],
            'current' => ['temp' => 20]
        ];
        $weatherServiceMock = Mockery::mock(WeatherServiceInterface::class);
        $weatherServiceMock->shouldReceive('getWeather')
            ->with('Madrid', 'es')
            ->andReturn($weatherData);

        $searchRecorderMock = Mockery::mock(WeatherSearchRecorderInterface::class);
        $searchRecorderMock->shouldReceive('record')
            ->once()
            ->with($weatherData, 'Madrid', 'Spain');

        $userWeatherSearchServiceMock = Mockery::mock(UserWeatherSearchService::class);

        $controller = new WeatherController(
            $weatherServiceMock,
            $searchRecorderMock,
            $userWeatherSearchServiceMock
        );

        $response = $controller->search($request);

        $this->assertInstanceOf(WeatherResource::class, $response);
    }

    public function test_recent_searches_returns_collection_of_weather_search_resources()
    {
        $request = Mockery::mock(RecentSearchesRequest::class);

        $userMock = Mockery::mock(User::class);
        $request->shouldReceive('user')->andReturn($userMock);

        $searches = collect([
            (object) ['city' => 'Madrid', 'country' => 'Spain'],
            (object) ['city' => 'Paris', 'country' => 'France'],
        ]);

        $userWeatherSearchServiceMock = Mockery::mock(UserWeatherSearchService::class);
        $userWeatherSearchServiceMock->shouldReceive('getRecentSearches')
            ->with($userMock)
            ->andReturn($searches);

        $weatherServiceMock = Mockery::mock(WeatherServiceInterface::class);
        $searchRecorderMock = Mockery::mock(WeatherSearchRecorderInterface::class);

        $controller = new WeatherController(
            $weatherServiceMock,
            $searchRecorderMock,
            $userWeatherSearchServiceMock
        );

        $response = $controller->recentSearches($request);

        $this->assertInstanceOf(\Illuminate\Http\Resources\Json\AnonymousResourceCollection::class, $response);
        $this->assertCount(2, $response->collection);
        $this->assertInstanceOf(WeatherSearchResource::class, $response->collection->first());
    }
}
