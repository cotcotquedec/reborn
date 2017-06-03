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


        $name = "Le.Bureau.Des.Legendes.S03E10.FiNAL.FRENCH.HDTV.x264-AMB3R.mkv";

        $tvshows = collect();

        //TVSHOW
        if (preg_match('#(?<title>.+)S(?<season>\d{2})E(?<episode>\d{2}).+#', $name, $match)) {
            $title = str_replace(['_', '.'], ' ', $match['title']);
            $season = $match['season'];
            $episode = $match['episode'];
            $language = 'fr-FR';


            // TVSHOW
            $search = \Tmdb::getSearchApi()->searchTv($title, compact('language'));

            if ($search['total_results']) {
                collect($search['results'])->each(function ($result) use ($tvshows, $season, $episode) {

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


        return 'Are you happy with your script';
    }
}