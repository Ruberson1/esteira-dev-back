<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Status\Status;
use App\Repositories\IRepository;
use App\Repositories\Status\StatusRepository;
use App\Services\IService;
use App\Services\Status\StatusService;
use Illuminate\Support\ServiceProvider;

class StatusServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(StatusService::class, function ($app) {
           return new StatusService(new StatusRepository(new Status()));
        });
    }
}
