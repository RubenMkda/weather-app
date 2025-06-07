<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Weather\WeatherController;
use App\Http\Middleware\Auth\OptionalAuthWithLimit;

Route::post('/weather/search', [WeatherController::class, 'search'])->middleware(OptionalAuthWithLimit::class);
Route::get('/weather/recentSearches', [WeatherController::class, 'recentSearches'])->middleware('auth:sanctum');