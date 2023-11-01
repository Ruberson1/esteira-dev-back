<?php

declare(strict_types=1);

namespace App\Models\Pull;

use App\Models\Task\Task;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pull
 * @package App\Models\Pull
 */
class Pull extends Model
{

    /**
     * @var string
     */
    protected $table = 'pull';

    /**
     * @var string[]
     */
    protected $fillable = [
        'link_v2',
        'link_front',
        'link_micros',
        'user_id',
        'task_id',
        'approved'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array|string[]
     */
    public $rules = [
        'user_id' => 'required|numeric',
        'task_id' => 'required|numeric',
    ];

    protected $casts = [
        'approved' => 'boolean',
    ];

    protected $with = [
        'task',
        'user'
    ];
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}