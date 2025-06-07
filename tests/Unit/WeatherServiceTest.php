<?php

namespace Tests\Unit;

use App\Services\Api\Weather\WeatherService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WeatherServiceTest extends TestCase
{
    public function test_weather_is_cached()
    {
        $city = 'Madrid';
        $lang = 'es';
        $cacheKey = "weather_{$city}_{$lang}";
    
        Cache::shouldReceive('remember')
            ->once()
            ->with($cacheKey, 600, \Closure::class)
            ->andReturnUsing(function ($key, $ttl, $callback) {
                return $callback();
            });
    
        Http::fake([
            'api.weatherapi.com/*' => Http::response([
                'location' => ['name' => $city],
                'current' => ['temp_c' => 20]
            ], 200)
        ]);
    
        Log::shouldReceive('info')->once();
    
        $service = new WeatherService();
    
        $result = $service->getWeather($city, $lang);

        $this->assertEquals('Madrid', $result['location']['name']);
    }
}
