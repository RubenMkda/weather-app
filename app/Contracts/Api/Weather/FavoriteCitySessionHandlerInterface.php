<?php

namespace App\Contracts\Api\Weather;

use Illuminate\Http\Request;

interface FavoriteCitySessionHandlerInterface
{
    public function storeFromSession(Request $request, int $userId): void;
    public function clearFavorites(Request $request): void;
    public function hasFavorites(Request $request): bool;
}
