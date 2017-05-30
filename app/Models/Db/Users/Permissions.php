<?php namespace App\Models\Db\Users;


use FrenchFrogs\Laravel\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Db\Users\Navigations;
use App\Models\Db\Users\Interfaces;
use \Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Db\Users\PermissionsGroups;


/**
 * 
 *
 * @property-read Collection|Navigations[] navigations
 * @property-read PermissionsGroups group
 * @property-read Interfaces interface
 * @property $sid
 * @property $group_sid
 * @property $interface_sid
 * @property $name
 * @property Carbon $deleted_at
 */
class Permissions extends Model
{
	use SoftDeletes;
	
	
	protected $table = 'users_permissions';
	
	
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
	function navigations()
	{
		return $this->hasMany(Navigations::class, "permission_sid", "sid");
	}
	
	
	/**
	 * 
	 *
	 * @return BelongsTo
	 */
	function interface()
	{
		return $this->belongsTo(Interfaces::class, "interface_sid", "sid");
	}
	
	
	/**
	 * 
	 *
	 * @return BelongsTo
	 */
	function group()
	{
		return $this->belongsTo(PermissionsGroups::class, "group_sid", "sid");
	}
}