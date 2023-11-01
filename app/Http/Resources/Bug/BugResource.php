<?php

namespace App\Http\Resources\Bug;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BugResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'user' => $this->user->name,
            'task_title' => $this->task->title,
            'tests' => $this->tests,
            'category' => $this->category->name,
            'description' => $this->description,
        ];
    }
}
