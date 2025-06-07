<?php

namespace Database\Factories\User;

use App\Models\User\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsUserLanguage>
 */
class LanguageFactory extends Factory
{

    protected $model = Language::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->languageCode,
            'name' => $this->faker->languageCode,
            'is_default' => false,
        ];
    }
}
