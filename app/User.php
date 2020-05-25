<?php

namespace App;

use App\Traits\Models\UserRelations;
use App\Traits\Models\UserScopes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $type
 * @property string $status
 * @property string $username
 * @property string $phone_1
 * @property string $phone_2
 * @property string $profile_2
 * @property int $manager_id
 */
class User extends Authenticatable
{
    use UserRelations, HasApiTokens, Notifiable, UserScopes;

    /// User status
    const USER_STATUS_ACTIVE = 'ACTIVE';
    const USER_STATUS_INACTIVE = 'INACTIVE';

    /// User types
    const USER_TYPE_COMMERCIAL = 'COMMERCIAL';
    const USER_TYPE_PHARMACY = 'PHARMACY';
    const USER_TYPE_SUPPLIER = 'SUPPLIER';
    const USER_TYPE_MASTER = 'MASTER';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'status',
        'username',
        'phone_1',
        'phone_2',
        'profile_id',
        'manager_id',
    ];

    protected $guarded = [
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime'
    ];
}
