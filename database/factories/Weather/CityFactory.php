<?php

namespace Database\Factories\Weather;

use App\Models\Weather\City;
use App\Models\Weather\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->city,
            'country_id' => Country::factory(),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}
