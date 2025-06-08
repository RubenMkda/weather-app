<?php

namespace App\Contracts\Api\Weather;

use Illuminate\Http\Request;

interface SessionWeatherDataPersisterInterface
{
    public function persistHistory(Request $request, int $userId): void;
    public function hasHistory(Request $request): bool;
}
