<?php

namespace Database\Seeders\User;

use App\Models\User;
use App\Enums\User\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'), 
            ]
        );

        $admin->assignRole(RoleEnum::ADMIN->value);
    }
}
