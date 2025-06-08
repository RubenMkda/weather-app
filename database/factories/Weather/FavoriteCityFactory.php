<?php

namespace Database\Factories\Weather;

use App\Models\User;
use App\Models\Weather\City;
use App\Models\Weather\FavoriteCity;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteCityFactory extends Factory
{
    protected $model = FavoriteCity::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'city_id' => City::factory(),
        ];
    }
}
