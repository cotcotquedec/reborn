<?php namespace App\Models\Db\Users;


use Carbon\Carbon;
use FrenchFrogs\Laravel\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;


/**
 *
 *
 * @property-read Interfaces userInterface
 * @property $uuid
 * @property $interface_sid
 * @property $name
 * @property $email
 * @property $parameters
 * @property $password
 * @property $api_token
 * @property $remember_token
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Users extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes;


    public $keyType = 'binuuid';
    protected $table = 'users';
    protected $primaryKey = 'uuid';
    protected $casts = [
        "uuid" => "binuuid"
    ];


    protected $dates = [
        "deleted_at",
        "created_at",
        "updated_at"
    ];


    /**
     *
     *
     * @return BelongsTo
     */
    function userInterface()
    {
        return $this->belongsTo(Interfaces::class, "interface_sid", "sid");
    }
}