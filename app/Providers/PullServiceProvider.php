<?php

declare(strict_types=1);

namespace App\Providers;


use App\Models\Pull\Pull;
use App\Repositories\Pull\PullRepository;
use App\Services\Pull\PullService;
use Illuminate\Support\ServiceProvider;

class PullServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PullService::class, function ($app) {
           return new PullService(new PullRepository(new Pull()));
        });
    }
}
