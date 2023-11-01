<?php

declare(strict_types=1);

namespace App\Repositories\Bug;

use App\Http\Resources\Bug\BugResource;
use App\Models\Bug\Bug;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class BugRepository
 * @package App\Repositories\Bug
 */
class BugRepository extends AbstractRepository
{

    public function findBugsDash()
    {
        $results = Bug::select(
            'user.name',
            DB::raw('COUNT(bug.user_id) as count')
        )
            ->join('user', 'bug.user_id', '=', 'user.id')
            ->groupBy('bug.user_id', 'user.name')
            ->get()->toArray();

        return [
            'names' => array_column($results, "name"),
            'counts' => array_column($results, "count"),
        ];
    }


    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        return $this->model::create($data)->toArray();
    }

    /**
     * @param int $userId
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByUser(int $userId, int $limit = 10, array $orderBy = []): array
    {
        $results = $this->model::where('user_id', $userId);
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

    /**
     * @param string $param
     * @return array
     */
    public function findBy(string $param): array
    {
        $query = $this->model::query();

        if (is_numeric($param)) {
            $bug = $query->findOrFail($param);
        } else {
            $bug = $query->where('slug', $param)
                ->get();
        }
        return $bug->toArray();
    }

    /**
     * @param int $taskId
     * @return bool
     */
    public function deleteByTask(int $taskId): bool
    {
        $bug = $this->model::where('task_id', $taskId)
            ->delete();
        return (bool)$bug;
    }
}
