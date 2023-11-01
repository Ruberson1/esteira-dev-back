<?php

namespace App\Http\Resources\History;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;


class HistoryResource extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'user' => $this->user->name,
            'status' => $this->status->name,
            'task' => $this->task->title,
            'history_date' => $this->history_date,
        ];
    }
}
