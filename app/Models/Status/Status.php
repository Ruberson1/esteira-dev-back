<?php

declare(strict_types=1);

namespace App\Models\Status;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 * @package App\Models\Status
 */
class Status extends Model
{
    /**
     * @var string
     */
    protected $table = 'status';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'active'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array|string[]
     */
    public array $rules = [
        'name' => 'required|min:2|unique:status|max:60',
    ];

}