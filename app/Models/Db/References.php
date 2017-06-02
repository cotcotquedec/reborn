<?php namespace App\Models\Db;


use Carbon\Carbon;
use FrenchFrogs\Laravel\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 *
 *
 * @property $rid
 * @property $name
 * @property $collection
 * @property array $data
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class References extends Model
{
    use SoftDeletes;


    public $incrementing = false;
    protected $table = 'references';
    protected $primaryKey = 'rid';
    protected $casts = [
        "data" => "json"
    ];


    protected $dates = [
        "deleted_at",
        "created_at",
        "updated_at"
    ];
}