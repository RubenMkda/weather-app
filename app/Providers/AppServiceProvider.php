<?php

namespace App\Providers;

use App\Contracts\Api\Auth\UserServiceInterface;
use App\Contracts\Api\User\LanguageRepositoryInterface;
use App\Contracts\Api\User\TokenServiceInterface;
use App\Contracts\Api\Weather\GuestWeatherHistoryManagerInterface;
use App\Contracts\Api\Weather\SessionWeatherManagerInterface;
use App\Contracts\Api\Weather\WeatherSearchRecorderInterface;
use App\Contracts\Api\Weather\WeatherServiceInterface;
use App\Repositories\Api\LanguageRepository;
use App\Services\Api\Weather\WeatherSearchRecorder;
use App\Services\Api\Weather\WeatherService;
use App\Services\Api\Auth\TokenService;
use App\Services\Api\Auth\UserService;
use App\Services\Api\Weather\GuestWeatherHistoryManager;
use App\Services\Api\Weather\SessionWeatherManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(TokenServiceInterface::class, TokenService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(WeatherServiceInterface::class, WeatherService::class);
        $this->app->bind(WeatherSearchRecorderInterface::class, WeatherSearchRecorder::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
