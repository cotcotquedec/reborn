<?php namespace App\Models\Db;


use Carbon\Carbon;
use FrenchFrogs\Laravel\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;


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
    use Searchable;

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


    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // REMOVE BAD INFO
        unset($array['search_info']);

        // FORMAT UUID
        $array['uuid'] = uuid($this->uuid)->string;

        $data = [];


        if ($this->isMovie()) {

            //
            $before = data_get($array['data'], 'movie');

            // GENRE
            if (!empty($before['genres'])) {
                $data['genres'] = collect($before['genres'])->pluck('name')->toArray();
            }

            $data['id'] = $before['id'];
            $data['title'] = $before['title'];
            $data['imdb_id'] = $before['imdb_id'];
            $data['tagline'] = $before['tagline'];
            $data['overview'] = $before['overview'];
            $data['poster_path'] = $before['poster_path'];
            $data['release_date'] = $before['release_date'];
            $data['backdrop_path'] = $before['backdrop_path'];
            $data['original_title'] = $before['original_title'];

        } elseif ($this->isTvShow()) {

            // TVSHOW
            $before = data_get($array['data'], 'tvshow');
            $imdb = data_get($before['ids'], 'imdb_id');
            $before = data_get($before, 'data');
            $tvshow = [];

            // GENRE
            if (!empty($before['genres'])) {
                $tvshow['genres'] = collect($before['genres'])->pluck('name')->toArray();
            }

            $tvshow['id'] = $before['id'];
            $tvshow['imdb_id'] = $imdb;
            $tvshow['name'] = $before['name'];
            $tvshow['overview'] = $before['overview'];
            $tvshow['poster_path'] = $before['poster_path'];
            $tvshow['backdrop_path'] = $before['backdrop_path'];
            $tvshow['original_name'] = $before['original_name'];


            // EPISODE
            $before = data_get($array['data'], 'episode');
            $imdb = data_get($before['ids'], 'imdb_id');
            $before = data_get($before, 'data');
            $episode = [];

            $episode['id'] = $before['id'];
            $episode['name'] = $before['name'];
            $episode['season_number'] = $before['season_number'];
            $episode['episode_number'] = $before['episode_number'];
            $episode['imdb_id'] = $imdb;
            $episode['air_date'] = $before['air_date'];
            $episode['overview'] = $before['overview'];

            $data = compact('tvshow', 'episode');
        }


        $array['data'] = $data;

        return $array;
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function getScoutKey()
    {
        return uuid($this->getKey())->string;
    }


    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        return $this->status_rid == \Ref::MEDIA_STATUS_STORED;
    }
}