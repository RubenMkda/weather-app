<?php

namespace App\Providers;

use App\Contracts\Api\User\LanguageRepositoryInterface;
use App\Contracts\Api\User\TokenServiceInterface;
use App\Contracts\User\LanguageServiceInterface;
use App\Repositories\Api\LanguageRepository;
use App\Services\Api\Auth\TokenService;
use App\Services\Api\User\LanguageService;
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

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
