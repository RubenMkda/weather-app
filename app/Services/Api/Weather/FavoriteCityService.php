<?php

namespace App\Services\Api\Weather;

use App\Contracts\Api\Weather\FavoriteCityServiceInterface;
use App\Models\Weather\FavoriteCity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class FavoriteCityService implements FavoriteCityServiceInterface
{
    public function getUserFavorites(): Collection
    {
        return FavoriteCity::where('user_id', Auth::id())
            ->with('city')
            ->get();
    }

    public function createFavorite(int $cityId): FavoriteCity
    {
        return FavoriteCity::firstOrCreate([
            'user_id' => Auth::id(),
            'city_id' => $cityId,
        ]);
    }

    public function getFavoriteById(int $id): FavoriteCity
    {   
        $favorite = FavoriteCity::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('city')
            ->first();

        if (!$favorite) {
            abort(404, 'No existe este favorito, intenta agregar la ciudad que buscas');
        }
        
        return $favorite;
        
    }

    public function deleteFavorite(int $id): void
    {
        $favorite = FavoriteCity::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $favorite->delete();
    }
}
