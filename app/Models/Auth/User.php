<?php

namespace App\Models\Auth;

use App\Models\Customer;
use App\Models\Traits\Uuid;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Auth\Traits\Method\UserMethod;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\Traits\SendUserPasswordReset;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Auth\Traits\Relationship\UserRelationship;

/**
 * Class User.
 * @property int id
 * @property string uuid
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string mobile
 * @property string avatar_type
 * @property string avatar_location
 * @property string password
 * @property int active
 * @property int confirmed
 * @property string confirmation_code
 * @property string timezone
 * @property string api_token
 * @property string remember_token
 * @property string last_login_ip
 * @property Carbon last_login_at
 * @property Carbon password_changed_at
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 *
 * @property Customer customer
 */
class User extends Authenticatable
{
    use HasApiTokens,
        HasRoles,
        Notifiable,
        SendUserPasswordReset,
        SoftDeletes,
        UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope,
        Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'avatar_type',
        'avatar_location',
        'password',
        'password_changed_at',
        'active',
        'confirmation_code',
        'confirmed',
        'timezone',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'api_token'];

    /**
     * @var array
     */
    protected $dates = ['last_login_at', 'deleted_at', 'password_changed_at'];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'confirmed' => 'boolean',
    ];
}
