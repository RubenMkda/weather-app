<?php

namespace App\Policies\Weather;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\User\PermissionEnum;
use App\Models\Weather\FavoriteCity;

class FavoriteCityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::READ_FAVORITE_CITY->value);
    }

    public function view(User $user, FavoriteCity $favoriteCity): bool
    {
        return $user->hasPermission(PermissionEnum::READ_FAVORITE_CITY->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::CREATE_FAVORITE_CITY->value);
    }

    public function delete(User $user, FavoriteCity $favoriteCity): bool
    {
        return $user->hasPermission(PermissionEnum::DELETE_FAVORITE_CITY->value);
    }
}
