<?php

namespace App\Http\Resources\Task;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'user' => [
                'user_name' => $this->user->name,
                'user_id' => $this->user->id
            ],
            'status' => $this->status->name,
            'task_date' => date('d/m/Y', strtotime($this->task_date)),
            'req_homolog_date' => date('d/m/Y', strtotime($this->homolog_date)),
            'homolog_date' => date('d/m/Y', strtotime($this->homolog_date)),
            'dev_date' => date('d/m/Y', strtotime($this->dev_date)),
            'homolog_delay' => $this->homolog_date > $this->req_homolog_date,
            'dev_delay' => $this->dev_date > $this->task_date,
            'description' => $this->description,
        ];
    }
}
