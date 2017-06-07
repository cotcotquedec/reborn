<?php namespace App\Models;

use App\Models\Db\Medias;
use Carbon\Carbon;

class Media
{

    /**
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    protected $storage;

    /**
     * @var
     */
    protected $md5;

    /**
     * @var
     */
    protected $realpath;

    /**
     * @var
     */
    protected $file;


    /**
     * @var
     */
    protected $data;


    /**
     * @var Medias
     */
    protected $db;


    /**
     * Media constructor.
     */
    public function __construct($file)
    {
        $this->storage = \Storage::disk('files');
        $this->file = $file;
        $this->detectRealPath();
        if (!$this->storage->exists($this->file)) {
            throw new \Exception('Le fichier n\'existe pas : ' . $this->file);
        }
    }

    /**
     *
     *
     * @param $file
     * @return bool|string
     */
    public function detectRealPath()
    {
        // ROOT
        $root = $this->getStorage()->getDriver()->getAdapter()->getPathPrefix();
        $this->realpath = realpath($root . DIRECTORY_SEPARATOR . $this->file);

        // TEST DU FICHIER
        if (empty($this->realpath)) {
            throw new \Exception('Impossible de trouver le fichier : ' . $this->file);
        }

        return $this;
    }

    /**
     *
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @param Medias $db
     * @return Media
     * @throws \Exception
     */
    static public function fromDb(Medias $db)
    {
        $media = new Media($db->storage_path);

        $copy = $media->db(false);

        if (is_null($copy) || $copy->getKey() != $db->getKey()) {
            throw new \Exception('Erreur sur l\identification du fichier');
        }

        return $media;
    }

    /**
     *
     * Return the MEdia Db model
     *
     * @return Db\Medias
     */
    public function db($create = true)
    {

        if (!$this->db) {

            if ($create) {
                /** @var $model \App\Models\Db\Medias */
                $model = \App\Models\Db\Medias::firstOrCreate([
                    'file_md5' => $this->md5(),
                    'storage_path' => $this->file
                ], [
                    'status_rid' => \Ref::MEDIA_STATUS_NEW,
                    'name' => basename($this->file),
                    'realpath' => $this->getRealpath(),
                    'dirname' => dirname($this->file),
                ]);
            } else {
                $model = \App\Models\Db\Medias::where('file_md5', $this->md5())
                    ->where('storage_path', $this->file)
                    ->firstOrFail();
            }

            $this->db = $model;
        }

        return $this->db;
    }

    /**
     * @return mixed
     */
    public function md5()
    {
        if (empty($this->md5)) {
            $this->detectMd5();
        }

        return $this->md5;
    }

    /**
     *
     *
     * @return $this
     */
    public function detectMd5()
    {
        $this->md5 = md5_file($this->getRealpath());
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRealpath()
    {
        return $this->realpath;
    }

    /**
     * @param $tmdb
     * @return $this
     * @throws \Exception
     */
    public function store($tmdb)
    {
        $db = $this->db;
        $data = $db->search_info[$tmdb];

        // FILM
        if ($db->isMovie()) {

            // DESTINATION
            $destination = sprintf('%s/%s/%s',
                config('filesystems.directories.movies'),
                ucfirst(str_slug($data['search']['title'])),
//                $data['search']['id'],
                basename($this->file)
            );


        } elseif ($db->isTvShow()) {

            // DESTINATION
            $destination = sprintf('%s/%s/Saison_%02s/Episode_%02s/%s',
                config('filesystems.directories.tvshows'),
                ucfirst(str_slug($data['search']['name'])),
//                $data['search']['id'],
                $data['episode']['data']['season_number'],
                $data['episode']['data']['episode_number'],
                ucfirst(str_slug($data['episode']['data']['name'])),
//                $data['episode']['data']['id'],
                basename($this->file)
            );
        }

        // SI VIDE
        if (empty($destination)) {
            throw new \Exception('Impossible de determiner une destionation pour le fichier : ' . $this->file);
        }

        // MOVE
        if (!$this->storage->move($db->storage_path, $destination)) {
            throw new \Exception('Erreur sur le deplacement du fichier : ' . $this->file);
        }

        // MAJ DB
        $this->file = $destination;
        $this->detectRealPath();
        if (!$this->storage->exists($this->file)) {
            throw new \Exception('Le fichier n\'existe pas : ' . $this->file);
        }
        $db->update([
            'name' => basename($this->file),
            'realpath' => $this->getRealpath(),
            'storage_path' => $this->file,
            'dirname' => dirname($this->file),
            'data' => $data,
            'stored_at' => Carbon::now(),
            'status_rid' => \Ref::MEDIA_STATUS_STORED
        ]);

        return $this;
    }

    /**
     * Search
     *
     * @param $file
     * @param null $search
     * @param null $year
     * @param null $season
     * @param null $episode
     */
    public function search($search = null, $year = null, $season = null, $episode = null)
    {

        if (!$this->isVideo()) {
            throw new \Exception('Ce fichier n\'est pas reconnu comme une video : ' . $this->file);
        }

        // INIT
        $movies = collect();
        $tvshows = collect();
        collect(explode('/', urldecode($this->file)))->reverse()->each(function ($name) use ($movies, $tvshows) {

            $match = [];

            //TVSHOW
            if (preg_match('#(?<title>.+)S(?<season>\d{2})E(?<episode>\d{2}).+#', $name, $match)
            || preg_match('#(?<title>.+)(?<season>\d{1,2})x(?<episode>\d{1,2}).+#', $name, $match)) {
                $title = trim(str_replace(['_', '.'], ' ', $match['title']));
                $season = $match['season'];
                $episode = $match['episode'];
                $language = 'fr-FR';

                d('SERIE : ' . $title);

                // TVSHOW
                $search = \Tmdb::getSearchApi()->searchTv($title, compact('language'));

                // PATCH YEAR ON SERIE NAME
                if (!$search['total_results']) {
                    if (preg_match('#(?<title>.+)\d{4}$#', $title, $match)) {
                        $search = \Tmdb::getSearchApi()->searchTv(trim($match['title']), compact('language'));
                    }
                }



                if ($search['total_results']) {
                    collect($search['results'])->each(function ($result) use ($tvshows, $season, $episode) {

                        // ON essaie de recuperer les informations
                        try {
                            $data_episode = \Tmdb::getTvEpisodeApi()->getEpisode($result['id'], $season, $episode);
                        } catch (\Exception $e) {
                            return;
                        }

                        // recherche
                        $data = [
                            'search' => $result,
                            'tvshow' => [
                                'data' => \Tmdb::getTvApi()->getTvshow($result['id']),
                                'ids' => \Tmdb::getTvApi()->getExternalIds($result['id']),
                            ],
                            'episode' => [
                                'data' => $data_episode,
                                'ids' => \Tmdb::getTvEpisodeApi()->getExternalIds($result['id'], $season, $episode),
                            ]
                        ];

                        $tvshows->put($result['id'], $data);
                    });
                }
            }


            // MOVIE
            if (preg_match('#(?<title>.+)(?<year>\d{4}).+#', $name, $match)) {

                d('FILM : ' . $name);
                $year = $match['year'];
                $title = str_replace(['_', '.'], ' ', $match['title']);
                $language = 'fr-FR';

                $search = \Tmdb::getSearchApi()->searchMovies($title, compact('year', 'language'));

                if ($search['total_results']) {
                    collect($search['results'])->each(function ($result) use ($movies) {

                        // recherche
                        $data = [
                            'search' => $result,
                            'movie' => \Tmdb::getMoviesApi()->getMovie($result['id']),
                        ];

                        $movies->put($result['id'], $data);
                    });
                }
            }
        });

        // Synchro avec la base
        $db = $this->db();
        $db->search_info = null;
        $db->type_rid = null;


        if ($tvshows->isNotEmpty()) {
            $db->search_info = $tvshows->toArray();
            $db->type_rid = \Ref::MEDIA_TYPE_TVSHOW;
        } elseif ($movies->isNotEmpty()) {
            $db->search_info = $movies->toArray();
            $db->type_rid = \Ref::MEDIA_TYPE_MOVIE;
        }

        // CAS d'un success
        if ($db->isNew() && !empty($db->type_rid)) {
            $db->status_rid = \Ref::MEDIA_STATUS_SCAN;
        }

        // UPDATE
        $db->save();

        return $this;
    }

    /**
     * @return bool
     */
    public function isVideo()
    {
        return substr($this->mime(), 0, 5) === 'video';
    }


    /**
     * @return false|string
     */
    public function mime()
    {
        return $this->getStorage()->mimeType($this->file);
    }
}
