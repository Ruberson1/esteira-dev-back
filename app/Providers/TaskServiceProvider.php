<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Task\Task;
use App\Repositories\Task\TaskRepository;
use App\Services\IService;
use App\Services\Task\TaskService;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TaskService::class, function () {
           return new TaskService(new TaskRepository(new Task()));
        });
    }
}
