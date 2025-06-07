<?php

namespace Database\Factories\Weather;

use App\Models\Weather\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->country,
        ];
    }
}
