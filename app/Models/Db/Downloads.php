<?php namespace App\Models\Db;


use Carbon\Carbon;
use FrenchFrogs\Laravel\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 *
 *
 * @property-read References status
 * @property $uuid
 * @property $status_rid
 * @property $url
 * @property $errors
 * @property Carbon $completed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Downloads extends Model
{
    public $keyType = 'binuuid';
    protected $table = 'downloads';
    protected $primaryKey = 'uuid';
    protected $casts = [
        "uuid" => "binuuid"
    ];


    protected $dates = [
        "completed_at",
        "created_at",
        "updated_at"
    ];


    /**
     *
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(References::class, "status_rid", "rid");
    }
}