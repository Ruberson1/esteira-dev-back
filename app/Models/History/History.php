<?php


declare(strict_types=1);

namespace App\Models\History;

use App\Models\Status\Status;
use App\Models\Task\Task;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class History
 * @package App\Models\History
 */
class History extends Model
{
    /**
     * @var string
     */
    protected $table = 'history';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'status_id',
        'task_id',
        'history_date',
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
        'task_id' => 'required|numeric',
        'history_date' => 'required|date',
    ];

    protected $with = [
        'task',
        'user',
        'status'
    ];

    protected $casts = [
        'history_date' => 'date:d-m-Y H:i:s',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}