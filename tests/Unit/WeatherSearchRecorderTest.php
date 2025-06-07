<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Weather\City;
use App\Models\Weather\Country;
use App\Models\Weather\WeatherSearch;
use App\Services\Api\Weather\WeatherSearchRecorder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class WeatherSearchRecorderTest extends TestCase
{
    use RefreshDatabase;

    public function test_record_creates_country_city_and_weather_search_for_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $weatherData = [
            'location' => [
                'name' => 'TestCity',
                'country' => 'TestCountry',
                'localtime' => '2025-06-07 12:00',
                'lat' => 10.123,
                'lon' => 20.456,
            ],
            'current' => [
                'temp_c' => 25,
                'condition' => [
                    'text' => 'Sunny',
                ],
                'wind_kph' => 15.5,    
                'humidity' => 60,      
            ],
        ];
        
        
        $cityName = 'TestCity';
        $countryName = 'TestCountry';

        $recorder = new WeatherSearchRecorder();

        $city = $recorder->record($weatherData, $cityName, $countryName);

        $this->assertDatabaseHas('countries', ['name' => $countryName]);

        $this->assertDatabaseHas('cities', [
            'name' => $cityName,
            'country_id' => $city->country_id,
            'latitude' => $weatherData['location']['lat'],
            'longitude' => $weatherData['location']['lon'],
        ]);

        $this->assertDatabaseHas('weather_searches', [
            'user_id' => $user->id,
            'city_id' => $city->id,
        ]);

        $this->assertInstanceOf(City::class, $city);
    }

    public function test_record_does_not_create_weather_search_if_no_authenticated_user()
    {
        Auth::logout();

        $weatherData = [
            'location' => ['lat' => 11.111, 'lon' => 22.222],
            'temp' => 30
        ];
        $cityName = 'NoUserCity';
        $countryName = 'NoUserCountry';

        $recorder = new WeatherSearchRecorder();

        $city = $recorder->record($weatherData, $cityName, $countryName);

        $this->assertDatabaseHas('countries', ['name' => $countryName]);
        $this->assertDatabaseHas('cities', ['name' => $cityName]);

        $this->assertDatabaseCount('weather_searches', 0);

        $this->assertInstanceOf(City::class, $city);
    }
}
