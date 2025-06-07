<?php

namespace Database\Seeders\User;

use App\Models\User;
use App\Enums\User\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateTestUsersSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole(RoleEnum::ADMIN->value);

        foreach (['user', 'language', 'country', 'city', 'weather_search', 'favorite_city'] as $model) {
            $roleName = "{$model}_manager";

            if ($roleName === 'user_manager') {
                continue;
            }

            $manager = User::firstOrCreate(
                ['email' => "{$roleName}@example.com"],
                [
                    'name' => ucfirst($roleName),
                    'password' => Hash::make('password'),
                ]
            );

            $manager->assignRole($roleName);
        }
    }
}
