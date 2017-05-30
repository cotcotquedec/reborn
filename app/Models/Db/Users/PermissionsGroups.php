<?php namespace App\Models\Db\Users;


use FrenchFrogs\Laravel\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Db\Users\Permissions;
use \Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * 
 *
 * @property-read Collection|Permissions[] permissions
 * @property $sid
 * @property $name
 * @property Carbon $deleted_at
 */
class PermissionsGroups extends Model
{
	use SoftDeletes;
	
	
	protected $table = 'users_permissions_groups';
	
	
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
	function permissions()
	{
		return $this->hasMany(Permissions::class, "group_sid", "sid");
	}
}