<?php

namespace App\Contracts\Api\Weather;

use Illuminate\Http\Request;

interface GuestWeatherHistoryManagerInterface
{
    public function addHistoryEntry(Request $request, int $cityId, array $weatherData): void;
    public function getHistory(Request $request): array;
    public function clearHistory(Request $request): void;
}
