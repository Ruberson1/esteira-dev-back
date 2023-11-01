<?php

declare(strict_types=1);

namespace App\Repositories\Pull;

use App\Repositories\AbstractRepository;

/**
 * Class PullRepository
 * @package App\Repositories\Pull
 */
class PullRepository extends AbstractRepository
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
     * @param int $statusId
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByStatus(int $statusId, int $limit = 10, array $orderBy = []): array
    {
        $results =  $this->model::where('approved', $statusId);

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
