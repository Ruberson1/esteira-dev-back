<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Repositories\AbstractRepository;
use App\User;

/**
 * Class UserRepository
 * @package App\Repositories\User
 */
class UserRepository extends AbstractRepository
{
    /**
     * @param $request
     * @return array
     */
    public function saveToken($request): array
    {
        $token = $request->fcm_token;
        $user = $request->user_id;

        $user = User::find($user);

        if ($user) {
            $user->fcm_token = $token;
            $user->save();

            return ['success' => true, 'message' => 'Token saved successfully'];
        }

        return ['success' => false, 'message' => 'User not found'];
    }
}