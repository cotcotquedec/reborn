<?php namespace App\Models\Db\Users;


use FrenchFrogs\Laravel\Database\Eloquent\Model;
use \Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * 
 *
 * @property $uuid
 * @property $name
 * @property Carbon $deleted_at
 */
class Groups extends Model
{
	use SoftDeletes;
	
	
	protected $table = 'users_groups';
	
	
	protected $primaryKey = 'uuid';
	
	
	public $keyType = 'binuuid';
	
	
	protected $casts = [
	    "uuid" => "binuuid"
	];
	
	
	protected $dates = [
	    "deleted_at"
	];
}