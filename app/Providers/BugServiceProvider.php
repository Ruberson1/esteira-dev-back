<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Bug\Bug;
use App\Repositories\Bug\BugRepository;
use App\Services\Bug\BugService;
use Illuminate\Support\ServiceProvider;

class BugServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BugService::class, function () {
           return new BugService(new BugRepository(new Bug()));
        });
    }
}
