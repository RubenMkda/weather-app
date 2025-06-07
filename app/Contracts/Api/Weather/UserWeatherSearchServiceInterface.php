<?php

namespace App\Contracts\Api\Weather;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserWeatherSearchServiceInterface
{
    public function getRecentSearches(User $user): Collection;
}
