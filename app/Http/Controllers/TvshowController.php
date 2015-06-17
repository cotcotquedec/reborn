<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Tvdb;

class TvshowController extends Controller
{

    public function import()
    {
        return view('tvshow.import');
    }


    public function loadtvshow(Request $request)
    {
        $options = [];
        try {

            if (!$request->has('query')) {throw new \InvalidArgumentException('La recherche est obligatoire');}

            $tvshow = Tvdb::getSeries($request->input('query'));

            foreach($tvshow as $id => $row) {
                $options[$id] = sprintf('%s (%s)', $row['name'], $row['year']);
            }

        } catch(\Exception $e) {
            $options = [];
        }

        return response()->json($options);
    }


    /**
     *
     * Renvoie la liste d'un episode pour une serie
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadepisode(Request $request)
    {

        $options = [];
        try {

            if (!$request->has('tvshow')) {throw new \InvalidArgumentException('L\'identifiant de la série est obligatoire');}

            $episode = Tvdb::getSerieEpisodes($request->input('tvshow'));

            foreach($episode as $id => $row) {

                // si pas de saison on zappe
                if (empty($row->season)) continue;

                $options[$id] = sprintf('S%02dE%02s [%s] %s',
                    $row->season,
                    $row->number,
                    $row->firstAired instanceof \DateTime ? $row->firstAired->format('d/m/Y') : '',
                    $row->name);
            }

        } catch(\Exception $e) {
            $options = [];
        }

        return response()->json($options);
    }
}
