<?php

namespace App\Services\Api\Weather;

use App\Contracts\Api\Weather\WeatherServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService implements WeatherServiceInterface
{
    public function getWeather(string $city, string $lang = 'en'): array
    {
        $cacheKey = "weather_{$city}_{$lang}";
    
        return Cache::remember($cacheKey, 600, function () use ($city, $lang) {
            Log::info("Llamando al endpoint de WeatherAPI para {$city} con idioma {$lang}");
    
            $apiKey = config('services.weatherapi.key');
            $response = Http::get("http://api.weatherapi.com/v1/current.json", [
                'key' => $apiKey,
                'q' => $city,
                'aqi' => 'no',
                'lang' => $lang 
            ]);
    
            if ($response->unauthorized()) {
                Log::warning("WeatherAPI: Unauthorized (401) para {$city}");
                abort(401, 'No autorizado para acceder');
            }
    
            if ($response->status() === 402) {
                Log::warning("WeatherAPI: Payment Required (402) para {$city}");
                abort(402, 'El plan requiere actualización.');
            }
    
            if ($response->forbidden()) {
                Log::warning("WeatherAPI: Forbidden (403) para {$city}");
                abort(403, 'Acceso prohibido a WeatherAPI.');
            }
    
            if ($response->failed()) {
                Log::error("WeatherAPI fallo para {$city}: " . $response->body());
                abort(500, 'Fallo en la solicitud.');
            }
    
            return $response->json();
        });
    }
    
    
}
