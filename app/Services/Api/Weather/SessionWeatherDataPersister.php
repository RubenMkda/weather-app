<?php

namespace App\Services\Api\Weather;

use App\Contracts\Api\Weather\GuestWeatherHistoryManagerInterface;
use App\Contracts\Api\Weather\SessionWeatherDataPersisterInterface;
use App\Models\Weather\WeatherSearch;
use Illuminate\Http\Request;

class SessionWeatherDataPersister implements SessionWeatherDataPersisterInterface
{
    protected GuestWeatherHistoryManagerInterface $historyManager;

    public function __construct(GuestWeatherHistoryManagerInterface $historyManager)
    {
        $this->historyManager = $historyManager;
    }

    public function persistHistory(Request $request, int $userId): void
    {
        $history = $this->historyManager->getHistory($request);

        foreach ($history as $entry) {
            if (isset($entry['city_id'], $entry['weather_data'], $entry['searched_at'])) {
                WeatherSearch::create([
                    'user_id' => $userId,
                    'city_id' => $entry['city_id'],
                    'weather_data' => $entry['weather_data'],
                    'searched_at' => $entry['searched_at'],
                ]);
            }
        }

        $this->historyManager->clearHistory($request);
    }

    public function hasHistory(Request $request): bool
    {
        return $request->session()->has('weather_history');
    }
}
