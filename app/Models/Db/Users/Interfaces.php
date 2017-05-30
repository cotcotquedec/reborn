<?php namespace App\Models\Db\Users;


use FrenchFrogs\Laravel\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Db\Users\Users;
use \Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Db\Users\Navigations;
use App\Models\Db\Users\Permissions;


/**
 * 
 *
 * @property-read Collection|Users[] users
 * @property-read Collection|Navigations[] navigations
 * @property-read Collection|Permissions[] permissions
 * @property $sid
 * @property $name
 * @property Carbon $deleted_at
 */
class Interfaces extends Model
{
	use SoftDeletes;
	
	
	protected $table = 'users_interfaces';
	
	
	protected $primaryKey = 'sid';
	
	
	public $incrementing = false;
	
	
	protected $dates = [
	    "deleted_at"
	];
	
	
	/**
	 * 
	 *
	 * @return HasMany
	 */
	function users()
	{
		return $this->hasMany(Users::class, "interface_sid", "sid");
	}
	
	
	/**
	 * 
	 *
	 * @return HasMany
	 */
	function navigations()
	{
		return $this->hasMany(Navigations::class, "interface_sid", "sid");
	}
	
	
	/**
	 * 
	 *
	 * @return HasMany
	 */
	function permissions()
	{
		return $this->hasMany(Permissions::class, "interface_sid", "sid");
	}
}