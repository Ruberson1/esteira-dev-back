<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\UserImage\UserImage;

use App\Repositories\UserImage\UserImageRepository;
use App\Services\UserImage\UserImageService;
use Illuminate\Support\ServiceProvider;

class UserImageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserImageService::class, function () {
           return new UserImageService(new UserImageRepository(new UserImage()));
        });
    }
}
