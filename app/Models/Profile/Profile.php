<?php

declare(strict_types=1);

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile
 * @package App\Models\Profile
 */
class Profile extends Model
{
    /**
     * @var string
     */
    protected $table = 'profile';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'active',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    public $rules = [
        'name' => 'required|min:2|unique:profile|max:60',
    ];
}