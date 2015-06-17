<?php namespace Db;

use Illuminate\Database\Eloquent\Model;

class ThetvdbSerie extends Model  {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'thetvdb_serie';
    public $timestamps = false;


    /**
     * return a collection of episode
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * *
     */
    public function episodes()
    {
        return $this->hasMany('Db\ThetvdbEpisode', 'seriesid', 'id');
    }

}
