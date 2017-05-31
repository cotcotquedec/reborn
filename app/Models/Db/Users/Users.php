<?php namespace App\Models\Db\Users;


use FrenchFrogs\Laravel\Database\Eloquent\Model;
use \Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Db\Users\Interfaces;


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
class Users extends Model
{
	use SoftDeletes;
	
	
	protected $table = 'users';
	
	
	protected $primaryKey = 'uuid';
	
	
	public $keyType = 'binuuid';
	
	
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