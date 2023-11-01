<?php
namespace App\Repositories\UserImage;

use App\Models\UserImage\UserImage;

class UserImageRepository
{
    public function save($userId, $path)
    {
        return UserImage::create([
            'user_id' => $userId,
            'path' => $path,
        ]);
    }
}