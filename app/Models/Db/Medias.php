<?php namespace App\Models\Db;


use Carbon\Carbon;
use FrenchFrogs\Laravel\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * 
 *
 * @property $uuid
 * @property $status_rid
 * @property $type_rid
 * @property $name
 * @property $dirname
 * @property $realpath
 * @property $storage_path
 * @property $file_md5
 * @property array $search_info
 * @property array $data
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $stored_at
 */
class Medias extends Model
{
    public $keyType = 'binuuid';


    protected $table = 'medias';


    protected $primaryKey = 'uuid';


    protected $casts = [
        "uuid" => "binuuid",
        "search_info" => "json",
        "data" => "json"
    ];


    protected $dates = [
        "created_at",
        "updated_at",
        "stored_at"
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
     * @return bool
     */
    public function isNew()
    {
        return $this->status_rid == \Ref::MEDIA_STATUS_NEW;
    }


    /**
     *
     *
     * @return bool
     */
    public function isStored()
    {
        return $this->status_rid == \Ref::MEDIA_STATUS_STORED;
    }


    /**
     *
     *
     * @return bool
     */
    public function isMovie()
    {
        return $this->type_rid == \Ref::MEDIA_TYPE_MOVIE;
    }


    /**
     *
     *
     * @return bool
     */
    public function isTvShow()
    {
        return $this->type_rid == \Ref::MEDIA_TYPE_TVSHOW;
    }
}