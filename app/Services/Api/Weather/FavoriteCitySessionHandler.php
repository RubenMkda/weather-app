<?php

namespace App\Services\Api\Weather;

use App\Contracts\Api\Weather\FavoriteCitySessionHandlerInterface;
use App\Models\Weather\FavoriteCity;
use Illuminate\Http\Request;

class FavoriteCitySessionHandler implements FavoriteCitySessionHandlerInterface
{
    public function storeFromSession(Request $request, int $userId): void
    {
        $favorites = $request->session()->get('favorite_cities', []);
        foreach ($favorites as $cityId) {
            FavoriteCity::firstOrCreate([
                'user_id' => $userId,
                'city_id' => $cityId,
            ]);
        }

        $this->clearFavorites($request);
    }

    public function clearFavorites(Request $request): void
    {
        $request->session()->forget('favorite_cities');
    }

    public function hasFavorites(Request $request): bool
    {
        return $request->session()->has('favorite_cities');
    }
}
