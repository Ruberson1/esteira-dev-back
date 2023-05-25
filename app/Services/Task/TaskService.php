<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Http\Resources\Task\TaskResource;
use App\Services\AbstractService;


/**
 * Class TaskService
 * @package App\Services\Task
 */
class TaskService extends AbstractService
{

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
     * @param int $statusId
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByStatus(int $statusId, int $limit = 10, array $orderBy = []): array
    {
        return $this->repository->findByStatus($statusId, $limit, $orderBy);
    }

    /**
     * @param string $param
     * @return array
     */
    public function findBy(string $param): array
    {
        return $this->repository->findBy($param);
    }
}
