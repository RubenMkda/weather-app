<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Weather\WeatherController;

Route::post('/weather/search', [WeatherController::class, 'search']);
Route::post('/weather/favorite', [WeatherController::class, 'favorite']);