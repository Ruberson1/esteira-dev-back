<?php

declare(strict_types=1);

namespace App\Repositories\History;

use App\Repositories\AbstractRepository;

const PENDENCY = 0;

/**
 * Class HistoryRepository
 * @package App\Repositories\History
 */
class HistoryRepository extends AbstractRepository
{
    /**
     * @param int $taskId
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByTask(int $taskId, int $limit = 10, array $orderBy = []): array
    {
        $results = $this->model::where('task_id', $taskId);
        foreach ($orderBy as $key => $value) {
            if (strstr($key, '-')) {
                $key = substr($key, 1);
            }

            $results->orderBy($key, $value);
        }

        return $results->paginate($limit)
            ->appends([
                'order_by' => implode(',', array_keys($orderBy)),
                'limit' => $limit
            ])
            ->toArray();
    }
}
