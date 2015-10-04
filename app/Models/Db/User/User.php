<?php namespace Models\Db\User;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $primaryKey  = 'user_id';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'is_active', 'is_contributor', 'is_admin'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function isActive()
    {
        return (bool) $this->is_active;
    }

    public function isContributor()
    {
        return (bool) $this->is_contributor;
    }

    public function isAdmin()
    {
        return (bool) $this->is_admin;
    }
}