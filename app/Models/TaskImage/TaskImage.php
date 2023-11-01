<?php


declare(strict_types=1);

namespace App\Models\TaskImage;

use App\Models\Task\Task;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaskImage
 * @package App\Models\TaskImage
 */
class TaskImage extends Model
{

    /**
     * @var string
     */
    protected $table = 'task_image';

    /**
     * @var string[]
     */
    protected $fillable = [
        'task_id',
        'path',
        'register_date',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array|string[]
     */
    public $rules = [
        'task_id' => 'required|numeric',
        'path' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ];

}