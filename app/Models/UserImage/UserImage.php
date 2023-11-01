<?php


declare(strict_types=1);

namespace App\Models\UserImage;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserImage
 * @package App\Models\UserImage
 */
class UserImage extends Model
{

    /**
     * @var string
     */
    protected $table = 'user_image';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
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
        'user_id' => 'required|numeric',
        'path' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ];

}