<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Services\AbstractService;


/**
 * Class UserService
 * @package App\Services\User
 */
class UserService extends AbstractService
{
    /**
     * @param $request
     * @return array
     */
    public function saveToken($request): array
    {
        return $this->repository->saveToken($request);
    }
}