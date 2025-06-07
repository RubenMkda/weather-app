<?php

namespace Database\Seeders;

use Database\Seeders\User\CreateTestUsersSeeder;
use Database\Seeders\User\RolesAndPermissionsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            RolesAndPermissionsSeeder::class,
            CreateTestUsersSeeder::class
        ]);
    }
}
