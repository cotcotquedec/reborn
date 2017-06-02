<?php namespace App\Http\Controllers;

use Tmdb\Helper\ImageHelper;

/**
 * Coucou les amis
 *
 * Class DevController
 * @package App\Http\Controllers\Inside
 */
class DevController extends Controller
{

    /**
     *
     *
     */
    public function layout()
    {
        return view('dev');
    }


    /**
     *
     *
     */
    public function script(ImageHelper $helper)
    {
        // STORAGE
        $storage = \Storage::disk('files');

        // PARCOURS DE TOUS LES FICHIERS
        collect($storage->files(null, true))->each(function ($file) use ($storage, $helper) {

            //FILTRE DES FICHIER VIDEO
            if (substr($storage->mimeType($file), 0, 5) !== 'video') {
                return;
            }

            // INIT
            $movies = $tvshows = collect();
            collect(explode('/', $file))->reverse()->each(function ($name) use ($movies, $tvshows, $helper) {

                $match = [];

                //TVSHOW
                if (preg_match('#(?<title>.+)S(?<season>\d{2})E(?<episode>\d{2}).+#', $name, $match)) {
                    $title = str_replace(['_', '.'], ' ', $match['title']);
                    $season = $match['season'];
                    $episode = $match['episode'];
                    $language = 'fr-FR';


                    // TVSHOW
                    $search = \Tmdb::getSearchApi()->searchTv($title, compact('language'));

                    if ($search['total_results']) {
                        collect($search['results'])->each(function ($result) use ($tvshows, $season, $episode, $helper) {

                            // recherche
                            $data = [
                                'search' => $result,
                                'tvshow' => [
                                    'data' => \Tmdb::getTvApi()->getTvshow($result['id']),
                                    'ids' => \Tmdb::getTvApi()->getExternalIds($result['id']),
                                ],
                                'episode' => [
                                    'data' => \Tmdb::getTvEpisodeApi()->getEpisode($result['id'], $season, $episode),
                                    'ids' => \Tmdb::getTvEpisodeApi()->getExternalIds($result['id'], $season, $episode),
                                ]
                            ];

                            $tvshows->put($result['id'], $data);
                        });
                    }
                }


                // MOVIE
                if (preg_match('#(?<title>.+)(?<year>\d{4}).+#', $name, $match)) {
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
                            $movies->push($result);
                        });
                    }
                }
            });


        });


        return 'Are you happy with your script';
    }
}