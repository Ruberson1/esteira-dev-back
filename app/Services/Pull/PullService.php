<?php

declare(strict_types=1);

namespace App\Services\Pull;

use App\Services\AbstractService;

/**
 * Class PullService
 * @package App\Services\Bug
 */
class PullService extends AbstractService
{
    /**
     * @param int $userId
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByUser(int $userId, int $limit = 10, $orderBy = []): array
    {
        return $this->repository->findByUser($userId, $limit, $orderBy);
    }

    /**
     * @param int $statusId
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByStatusImp(int $statusId, int $limit = 10, $orderBy = []): array
    {
        return $this->repository->findByStatus($statusId, $limit, $orderBy);
    }
}
