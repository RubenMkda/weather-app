<?php

namespace Database\Seeders\User;

use App\Enums\User\PermissionEnum;
use App\Enums\User\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (PermissionEnum::cases() as $permission) {
            Permission::firstOrCreate(['name' => $permission->value]);
        }

        Role::firstOrCreate(['name' => RoleEnum::ADMIN->value])
            ->syncPermissions(array_map(fn($p) => $p->value, PermissionEnum::cases()));

        Role::firstOrCreate(['name' => RoleEnum::USER->value])
            ->syncPermissions([
                PermissionEnum::READ_CITY->value,
                PermissionEnum::READ_COUNTRY->value,
                PermissionEnum::CREATE_FAVORITE_CITY->value,
                PermissionEnum::READ_FAVORITE_CITY->value,
                PermissionEnum::DELETE_FAVORITE_CITY->value,
                PermissionEnum::CREATE_WEATHER_SEARCH->value,
                PermissionEnum::READ_WEATHER_SEARCH->value,
            ]);

        foreach (['user', 'language', 'country', 'city', 'weather_search', 'favorite_city'] as $model) {
            $roleName = "{$model}_manager";
            $permissions = array_filter(PermissionEnum::cases(), fn($p) => str_contains($p->value, $model));
            Role::firstOrCreate(['name' => $roleName])
                ->syncPermissions(array_map(fn($p) => $p->value, $permissions));
        }
    }
}
