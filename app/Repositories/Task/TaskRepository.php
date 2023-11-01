<?php

declare(strict_types=1);

namespace App\Repositories\Task;


use App\Models\Task\Task;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
     * @param int $Id
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByIdRepository(int $Id, int $limit = 10, array $orderBy = []): array
    {
        $results =  $this->model::where('id', $Id);

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
     * @param int $limit
     * @param array $orderBy
     * @param $filters
     * @return array
     */
    public function findAllTasksRepository(int $limit = 10, array $orderBy = [], $filters): array
    {
        $user = Auth::user();
        if ($user->profile_id == env('USER_PROFILE_DEV')) {
            if(!isset($filters[0])){
                $results =  $this->model::where('user_id', $user->id);

                foreach ($orderBy as $key => $value) {
                    if (strpos($key, '-') !== false) {
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
            $adjustedFilters = $this->filtersAdjustment($filters);

            $query = Task::query(); // Inicializa uma consulta no modelo Task

            foreach ($adjustedFilters as $field => $value) {
                if ($field === 'task_date') {
                    $query->whereBetween('task_date', [$value[0], $value[1]]);
                } elseif ($field === 'title') {
                    $query->where('title', 'like', '%' . $value . '%');
                } else {
                    $query->whereIn($field, $value);
                }
            }

            foreach ($orderBy as $key => $value) {
                if (strpos($key, '-') !== false) {
                    $key = substr($key, 1);
                }

                $query->orderBy($key, $value);
            }

            return $query->paginate($limit)
                ->appends([
                    'order_by' => implode(',', array_keys($orderBy)),
                    'limit' => $limit
                ])
                ->toArray();

        }

        if(!isset($filters[0])){
            $results = $this->model::query();

            foreach ($orderBy as $key => $value) {
                if (strpos($key, '-') !== false) {
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
        $adjustedFilters = $this->filtersAdjustment($filters);

        $query = Task::query(); // Inicializa uma consulta no modelo Task

        foreach ($adjustedFilters as $field => $value) {
            if ($field === 'task_date') {
                $query->whereBetween('task_date', [$value[0], $value[1]]);
            } elseif ($field === 'title') {
                $query->where('title', 'like', '%' . $value . '%');
            } else {
                $query->whereIn($field, $value);
            }
        }

        foreach ($orderBy as $key => $value) {
            if (strpos($key, '-') !== false) {
                $key = substr($key, 1);
            }

            $query->orderBy($key, $value);
        }

        return $query->paginate($limit)
            ->appends([
                'order_by' => implode(',', array_keys($orderBy)),
                'limit' => $limit
            ])
            ->toArray();

    }

    public function findAllByStatus(): array
    {
        $results = Task::selectRaw('status.name, COUNT(task.status_id) as count')
            ->join('status', 'task.status_id', '=', 'status.id')
            ->groupBy('task.status_id', 'status.name')
            ->get()->toArray();

        return [
            'status_name' => array_column($results, "name"),
            'status_count' => array_column($results, "count"),
        ];
    }

    public function findAllByPeriod(): array
    {
        $results = Task::selectRaw('DATE_FORMAT(task_date, "%Y-%m") as task_month, MONTHNAME(task_date) as month_name, COUNT(*) as task_count')
            ->groupBy('task_month', 'month_name')
            ->orderBy('task_month')
            ->get()->toArray();

        return [
            'month_name' => array_column($results, "month_name"),
            'task_count' => array_column($results, "task_count"),
        ];
    }

    private function filtersAdjustment($filters) : array
    {
        $result = [];

        foreach ($filters as $filter) {
            if (is_array($filter)) {
                foreach ($filter as $key => $value) {
                    if (is_numeric($key)) {
                        foreach ($value as $innerKey => $innerValue) {
                            $result[$innerKey][] = $innerValue;
                        }
                    } else {
                        $result[$key] = $value;
                    }
                }
            }
        }

        return $result;
    }
}
