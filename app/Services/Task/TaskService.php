<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Http\Resources\Task\TaskResource;
use App\Services\AbstractService;
use App\Services\TaskImage\TaskImageService;
use Illuminate\Http\Request;


/**
 * Class TaskService
 * @package App\Services\Task
 */
class TaskService extends AbstractService
{
    /**
     * @param Request $request
     * @return array
     */
    public function createTask(Request $request): array
    {
        $task = $this->repository->create($request->all());
        $files = $request->file('files');
        if($files) {
            $taskImageService = new TaskImageService;
            $taskImageService->uploadImage($task['id'], $files);
        }
        return $task;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function update(Request $request): bool
    {
        $files = $request->file('files');
        $taskId = $request->get('id');
        if($files) {
            $taskImageService = new TaskImageService;
            $taskImageService->updateImage($request, (int)$taskId);
        }

        return $this->repository->editBy($taskId, $request->all());
    }

    /**
     * @param int $userId
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByUser(int $userId, int $limit = 10, array $orderBy = []): array
    {
        return $this->repository->findByUser($userId, $limit, $orderBy);
    }

    /**
     * @param int $Id
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByIdImp(int $Id, int $limit = 10, array $orderBy = []): array
    {
        return $this->repository->findByIdRepository($Id, $limit, $orderBy);
    }

    /**
     * @param int $limit
     * @param array $orderBy
     * @param $filters
     * @return array
     */
    public function findAllTasksImp(int $limit = 10, array $orderBy = [], $filters): array
    {
        return $this->repository->findAllTasksRepository($limit, $orderBy, $filters);
    }

    /**
     * @return array
     */
    public function findAllStatusImp(): array
    {
        return $this->repository->findAllByStatus();
    }

    /**
     * @return array
     */
    public function findAllPeriodImp(): array
    {
        return $this->repository->findAllByPeriod();
    }

}
