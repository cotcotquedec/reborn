<?php namespace App;

use Moinax\TvDb\Client;


class Tvdb {


    /**
     * Url pour le client
     *
     */
    const THETVDB_URL = "http://thetvdb.com";


    /**
     * Prefix pour les url de type banniere
     *
     */
    const THETVDB_BANNER_PREFIX = 'banners/';


    /**
     * Langue
     *
     */
    const THETVDB_LANG = 'fr';

    /**
     * @var Client
     */
    protected $client;


    /**
     * constructeur
     *
     *
     */
    public function __construct($apikey) {

        $this->client = new Client(static::THETVDB_URL, $apikey);

    }

    /**
     * Factory
     *
     * @return Tvdb
     */
    static function factory()
    {
        return new Tvdb( config('services.thetvdb.apikey'));
    }


    /**
     *
     * Recherche d'une serie
     *
     * @param $query
     * @return array
     */
    static function getSeries($query)
    {

        $data = static::factory()->getClient()->getSeries($query, static::THETVDB_LANG);


        // dedoublonnage
        $return  = [];
        foreach($data as &$row) {

            if (!empty($return[$row->id])) {
                continue;
            }

            $tvshow = [ 'name' => $row->name,
                        'id' => $row->id,
                        'overview' => $row->overview,
                        'banner' => static::url(static::THETVDB_BANNER_PREFIX . $row->banner),
                        'year' => $row->firstAired->format('Y')];
            $return[$row->id] = $tvshow;
        }

        return $return;
    }


    /**
     * getter pour le client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }


    /**
     * revnoie l'url de l'image
     *
     * @param $image
     * @return string
     *
     */
    static function url($image)
    {
        return static::THETVDB_URL . '/' . $image;
    }
}