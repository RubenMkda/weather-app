<?php

namespace App\Enums\User;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case USER_MANAGER = 'user_manager';
    case LANGUAGE_MANAGER = 'language_manager';
    case COUNTRY_MANAGER = 'country_manager';
    case CITY_MANAGER = 'city_manager';
    case WEATHER_SEARCH_MANAGER = 'weather_search_manager';
    case FAVORITE_CITY_MANAGER = 'favorite_city_manager';
}
