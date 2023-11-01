<?php


declare(strict_types=1);

namespace App\Models\BugImage;

use App\Models\Bug\Bug;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BugImage
 * @package App\Models\BugImage
 */
class BugImage extends Model
{

    /**
     * @var string
     */
    protected $table = 'bug_image';

    /**
     * @var string[]
     */
    protected $fillable = [
        'bug_id',
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
        'bug_id' => 'required|numeric',
        'path' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ];

}