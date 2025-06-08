<?php

namespace App\Contracts\Api\Weather;

use App\Models\User;
use Illuminate\Http\Request;

interface SessionWeatherManagerInterface
{
    public function handleSessionData(Request $request, User $user, int $cityId, array $weatherData): void;
}
