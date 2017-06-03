<?php namespace App\Models\Db\Users;


use Carbon\Carbon;
use FrenchFrogs\Laravel\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 *
 *
 * @property-read Interfaces interface
 * @property-read Navigations parent
 * @property-read Permissions permission
 * @property $sid
 * @property $interface_sid
 * @property $permission_sid
 * @property $parent_sid
 * @property $name
 * @property $link
 * @property $is_active
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Navigations extends Model
{
    use SoftDeletes;


    public $incrementing = false;
    protected $table = 'users_navigations';
    protected $primaryKey = 'sid';
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


    /**
     *
     *
     * @return bool
     */
    function isActive()
    {
        return (bool) $this->is_active;
    }


    /**
     *
     *
     * @return BelongsTo
     */
    function parent()
    {
        return $this->belongsTo(Navigations::class, "parent_sid", "sid");
    }


    /**
     *
     *
     * @return BelongsTo
     */
    function permission()
    {
        return $this->belongsTo(Permissions::class, "permission_sid", "sid");
    }
}