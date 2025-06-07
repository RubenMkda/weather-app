<?php

namespace App\Enums\User;

enum PermissionEnum: string
{
    // user
    case CREATE_USER = 'create user';
    case READ_USER = 'read user';
    case UPDATE_USER = 'update user';
    case DELETE_USER = 'delete user';

    // language
    case CREATE_LANGUAGE = 'create language';
    case READ_LANGUAGE = 'read language';
    case UPDATE_LANGUAGE = 'update language';
    case DELETE_LANGUAGE = 'delete language';

    // country
    case CREATE_COUNTRY = 'create country';
    case READ_COUNTRY = 'read country';
    case UPDATE_COUNTRY = 'update country';
    case DELETE_COUNTRY = 'delete country';

    // city
    case CREATE_CITY = 'create city';
    case READ_CITY = 'read city';
    case UPDATE_CITY = 'update city';
    case DELETE_CITY = 'delete city';

    // weather_search
    case CREATE_WEATHER_SEARCH = 'create weather_search';
    case READ_WEATHER_SEARCH = 'read weather_search';
    case UPDATE_WEATHER_SEARCH = 'update weather_search';
    case DELETE_WEATHER_SEARCH = 'delete weather_search';

    // favorite_city
    case CREATE_FAVORITE_CITY = 'create favorite_city';
    case READ_FAVORITE_CITY = 'read favorite_city';
    case UPDATE_FAVORITE_CITY = 'update favorite_city';
    case DELETE_FAVORITE_CITY = 'delete favorite_city';
}
