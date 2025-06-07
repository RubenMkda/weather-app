<?php

use App\Http\Controllers\Api\Weather\FavoriteCityController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favorites', [FavoriteCityController::class, 'index']);
    Route::post('/favorites', [FavoriteCityController::class, 'store']);
    Route::get('/favorites/{id}', [FavoriteCityController::class, 'show']);
    Route::delete('/favorites/{id}', [FavoriteCityController::class, 'destroy']);
});