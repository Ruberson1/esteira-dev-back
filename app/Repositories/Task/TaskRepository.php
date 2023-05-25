<?php

declare(strict_types=1);

namespace App\Repositories\Task;

use App\Http\Resources\Task\TaskResource;
use App\Repositories\AbstractRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use stdClass;

/**
 * Class TaskRepository
 * @package App\Repositories\Task
 */
class TaskRepository extends AbstractRepository
{
    /**
     * @param int $userId
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByUser(int $userId, int $limit = 10, array $orderBy = []): array
    {
        $results =  $this->model::where('user_id', $userId);

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

    /**
     * @param int $userId
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByStatus(int $statusId, int $limit = 10, array $orderBy = []): array
    {
        $results =  $this->model::whereIn('status_id', $statusId);

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

    /**
     * @param string $param
     * @return array
     */
    public function findBy(string $param): array
    {
        $query = $this->model::query();

        if (is_numeric($param)) {
            $task = $query->findOrFail($param);
        } else {
            $task = $query->where('slug', $param)
                ->get();
        }
        return $task->toArray();
    }
}
