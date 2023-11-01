<?php

declare(strict_types=1);

namespace App\Providers;


use App\Models\Profile\Profile;
use App\Repositories\Profile\ProfileRepository;
use App\Services\Profile\ProfileService;
use Illuminate\Support\ServiceProvider;

class ProfileServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProfileService::class, function () {
           return new ProfileService(new ProfileRepository(new Profile()));
        });
    }
}
