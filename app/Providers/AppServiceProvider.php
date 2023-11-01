<?php

namespace App\Providers;

use App\Http\Controllers\V1\Auth\IAuthService;
use App\Repositories\Auth\AuthRepository;
use App\Services\Auth\AuthService;
use App\Services\Auth\IAuthRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\SocialiteServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(AuthService::class, function ($app) {
        //     return new AuthService(new AuthRepository(new User()));
        //  });

        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(IAuthRepository::class, AuthRepository::class);
        $this->app->register(SocialiteServiceProvider::class);
    }
}
