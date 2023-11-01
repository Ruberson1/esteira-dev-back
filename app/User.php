<?php

declare(strict_types=1);

namespace App;

use App\Models\Profile\Profile;
use App\Models\UserImage\UserImage;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package App\User
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;
    /**
     * @var string
     */
    protected $table = 'user';

    /**
     * @var string[]
     */
    protected $fillable = [
        'profile_id',
        'provider',
        'provider_id',
        'name',
        'email',
        'active',
        'unauthorized',
        'fcm_token'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * @var bool
     */
    public $timestamps = false; //updated_at / deleted_at

    /**
     * @var array
     */
    public  array $rules = [
        'name' => 'required|min:2|max:20',
        'email' => 'required|email|max:100|email:rfc,dns',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $with = [
        'profile',
        'image'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function image()
    {
        return $this->hasOne(UserImage::class);
    }
}