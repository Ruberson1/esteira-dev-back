<?php

declare(strict_types=1);

namespace App\Models\Bug;

use App\Models\BugImage\BugImage;
use App\Models\Category\Category;
use App\Models\Task\Task;
use App;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Bug
 * @package App\Models\Bug
 */
class Bug extends Model
{

    /**
     * @var string
     */
    protected $table = 'bug';

    /**
     * @var string[]
     */
    protected $fillable = [
        'task_id',
        'user_id',
        'category_id',
        'title',
        'tests',
        'description',
        'created_at',
        'production'
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
        'category_id' => 'required|numeric',
        'title' => 'required|min:2|max:60',
        'tests' => 'required|min:20',
        'description' => 'required|min:20'
    ];

    protected $casts = [
        'created_at' => 'date:d/m/Y H:i:s',
        'production' => 'boolean'
    ];

    protected $with = [
        'task',
        'category',
        'user',
        'imageBug'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function imageBug()
    {
        return $this->hasMany(BugImage::class);
    }
}