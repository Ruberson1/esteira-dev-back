<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\User\UserRepository;
use App\Services\User\UserService;
use App\User;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserService::class, function () {
            return new UserService(new UserRepository(new User()));
        });
    }
}