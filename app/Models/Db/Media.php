<?php namespace App\Models\Db;


use Carbon\Carbon;
use FrenchFrogs\Laravel\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 *
 *
 * @property-read References status
 * @property-read References type
 * @property $uuid
 * @property $status_rid
 * @property $type_rid
 * @property $name
 * @property $directory
 * @property $filename
 * @property $file_md5
 * @property array $search_info
 * @property array $data
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Media extends Model
{
    public $keyType = 'binuuid';
    protected $table = 'media';
    protected $primaryKey = 'uuid';
    protected $casts = [
        "uuid" => "binuuid",
        "search_info" => "json",
        "data" => "json"
    ];


    protected $dates = [
        "created_at",
        "updated_at"
    ];


    /**
     *
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(References::class, "type_rid", "rid");
    }


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