<?php

declare(strict_types=1);

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App\Models\Category
 */
class Category extends Model
{
    /**
     * @var string
     */
    protected $table = 'category';

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
        'name' => 'required|min:2|unique:category|max:60',
    ];
}