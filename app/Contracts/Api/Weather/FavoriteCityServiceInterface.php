<?php

namespace App\Contracts\Api\Weather;
use App\Models\Weather\FavoriteCity;
use Illuminate\Database\Eloquent\Collection;

interface FavoriteCityServiceInterface
{
    public function getUserFavorites(): Collection;
    public function createFavorite(int $cityId): FavoriteCity;
    public function getFavoriteById(int $id): FavoriteCity;
    public function deleteFavorite(int $id): void;
}
