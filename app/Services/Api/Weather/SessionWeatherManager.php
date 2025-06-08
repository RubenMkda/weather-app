<?php

namespace App\Services\Api\Weather;

use App\Contracts\Api\Weather\SessionWeatherManagerInterface;
use App\Models\User;
use Illuminate\Http\Request;

class SessionWeatherManager implements SessionWeatherManagerInterface
{
    public function __construct(
        private GuestWeatherHistoryManager $guestHistory,
        private FavoriteCitySessionHandler $favoriteHandler,
        private SessionWeatherDataPersister $dataPersister
    ) {}

    public function handleSessionData(Request $request, ?User $user, int $cityId, array $weatherData): void
    {
        if (!$user) {
            $this->guestHistory->addHistoryEntry($request, $cityId, $weatherData);
            return;
        }

        if ($this->favoriteHandler->hasFavorites($request)) {
            $this->favoriteHandler->storeFromSession($request, $user->id);
        }

        if ($this->dataPersister->hasHistory($request)) {
            $this->dataPersister->persistHistory($request, $user->id);
        }
    }
}