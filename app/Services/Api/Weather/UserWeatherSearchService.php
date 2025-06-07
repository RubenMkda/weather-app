<?php

namespace App\Services\Api\Weather;

use App\Models\User;
use Illuminate\Support\Collection;

class UserWeatherSearchService
{
    public function getRecentSearches(User $user): Collection
    {
        return $user->recentWeatherSearches()->with('city')->get();
    }
}
