<?php

declare(strict_types=1);

namespace App\Services\History;

use App\Services\AbstractService;


/**
 * Class HistoryService
 * @package App\Services\History
 */
class HistoryService extends AbstractService
{
    /**
     * @param int $taskId
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByTask(int $taskId, int $limit = 10, $orderBy = []): array
    {
        return $this->repository->findByTask($taskId, $limit, $orderBy);
    }
}
