<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::factory()->spanish()->default()->create();
        Language::factory()->english()->create();
    }
}
