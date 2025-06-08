<?php

namespace App\Services\Api\Weather;

use App\Contracts\Api\Weather\GuestWeatherHistoryManagerInterface;
use Illuminate\Http\Request;

class GuestWeatherHistoryManager implements GuestWeatherHistoryManagerInterface
{
    public function addHistoryEntry(Request $request, int $cityId, array $weatherData): void
    {
        $history = $request->session()->get('weather_history', []);
        $history[] = [
            'city_id' => $cityId,
            'weather_data' => $weatherData,
            'searched_at' => now(),
        ];
        $request->session()->put('weather_history', $history);
    }

    public function getHistory(Request $request): array
    {
        return $request->session()->get('weather_history', []);
    }

    public function clearHistory(Request $request): void
    {
        $request->session()->forget('weather_history');
    }
}
