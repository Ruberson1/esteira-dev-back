<?php
namespace App\Repositories\TaskImage;

use App\Models\TaskImage\TaskImage;

class TaskImageRepository
{
    public function save($taskId, $path)
    {
        return TaskImage::create([
            'task_id' => $taskId,
            'path' => $path,
        ]);
    }
}