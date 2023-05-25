<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\History\History;
use App\Repositories\History\HistoryRepository;
use App\Services\History\HistoryService;
use Illuminate\Support\ServiceProvider;

class HistoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(HistoryService::class, function () {
           return new HistoryService(new HistoryRepository(new History()));
        });
    }
}
