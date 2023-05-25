<?php

declare(strict_types=1);

namespace App\Models\Task;

use App\Models\Bug\Bug;
use App\Models\History\History;
use App\Models\Status\Status;
use App\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Task
 * @package App\Models\Task
 */
class Task extends Model
{
    //use Sluggable;

    /**
     * @var string
     */
    protected $table = 'task';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'status_id',
        'title',
        'req_homolog_date',
        'homolog_date',
        'task_date',
        'dev_date',
        'description'
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
        'status_id' => 'required|numeric',
        'title' => 'required|min:2|max:120',
        'task_date' => 'required|date',
        'homolog_date' => 'nullable|date',
        'dev_date' => 'nullable|date',
        'req_homolog_date' => 'required|date',
        'description' => 'required|min:50'
    ];

    protected $with = [
        'user',
        'status',
    ];

    protected $casts = [
        'task_date' => 'date:d-m-Y',
        'homolog_date' => 'date:d-m-Y',
        'dev_date' => 'date:d-m-Y',
        'req_homolog_date' => 'date:d-m-Y'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function bugs()
    {
        return $this->hasMany(Bug::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($task) {
            $history = new History([
                'status_id' => $task->status_id,
                'user_id' => Auth::user()->getAuthIdentifier(),
                'task_id' => $task->id,
            ]);

            $task->histories()->save($history);
        });
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    // public function sluggable(): array
    // {
    //     return [
    //         'slug' => [
    //             'source' => ['nome', 'sobrenome'],
    //             'onUpdate' => true
    //         ]
    //     ];
    // }
}