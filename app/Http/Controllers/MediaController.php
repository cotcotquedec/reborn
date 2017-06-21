<?php

namespace App\Http\Controllers;

use App\Models\Db\Downloads;
use App\Models\Db\Medias;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{

    /**
     *
     * Index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function files()
    {
        $medias = Medias::where('status_rid', '!=', \Ref::MEDIA_STATUS_STORED)
//            ->where('type_rid', \Ref::MEDIA_TYPE_TVSHOW)
            ->get();

        return view('files', compact('medias'));
    }


    /**
     * @param $media
     * @param $tmdb
     * @return \FrenchFrogs\Container\Javascript
     */
    public function stock($media, $tmdb)
    {

        try {

            //VALIDATION
            $this->validate($request = $this->request(), ['__media' => 'required|exists:medias,uuid']);

            // MEDIA
            $media = Medias::findOrFail($request->get('__media'));

            // On verifie que le media n'st pas deja trié
            if ($media->isStored()) {
                throw new \LogicException('Ce media a déja été trié, désolé');
            }

            // ON verifie l'info
            if (empty($media->search_info[$tmdb])) {
                throw new \LogicException('Ce media ne contient pas dans sa base la recherche : ' . $tmdb);
            }


            $model = Media::fromDb($media);
            $model->store($tmdb);

            js()->success()->reload();
        } catch (\Exception $e) {
            js()->error($e->getMessage());
        }

        return js();
    }


    /**
     * Stockage d'un film
     *
     * @param $media
     * @return mixed
     */
    public function stockMovie($media)
    {
        //VALIDATION
        $this->validate($request = $this->request(), ['__media' => 'required|exists:medias,uuid']);

        // MEDIA
        $media = Medias::findOrFail($request->get('__media'));

        // FORMULAIRE
        $form = form()->enableRemote();
        $form->setLegend('Tri manuel de film');
        $form->addLabel('name', 'Fichier')->setValue($media->name);
        $form->addText('title', 'Titre')->addAttribute('autofocus', 'autofocus')->addLaravelValidator('min:3');
        $form->addNumber('year', 'Année', false)->addLaravelValidator('size:4');
        $form->addSubmit('Chercher');

        // TRAITEMENT
        if ($request->isMethod('POST')) {

            $form->valid($request->all());

            if ($form->isValid()) {


                try {

                    // Recherche de film
                    if (!$request->get('movie_id')) {
                        // recherche
                        $search = \Tmdb::getSearchApi()->searchMovies($request->get('title'), ['year' => $request->get('year')]);
                        $movies = [];

                        if (!empty($search['total_results'])) {

                            foreach ($search['results'] as $row) {

                                $title = $row['title'];

                                if (!empty($row['release_date'])) {
                                    $title .= sprintf(' (%d)', substr($row['release_date'], 0, 4));
                                }

                                $movies[$row['id']] = $title;
                            }

                            $form->addSelect('movie_id', 'Film', $movies);
                        }
                    } else {

                        transaction(function() use ($request, $media) {
                            // STOCKAGE
                            $movie = $request->get('movie_id');
                            $infos = \Tmdb::getMoviesApi()->getMovie($movie);

                            // Synchro avec la base
                            $media->search_info = [ $movie => ['movie' => $infos]];
                            $media->type_rid = \Ref::MEDIA_TYPE_MOVIE;
                            $media->status_rid = \Ref::MEDIA_STATUS_SCAN;
                            $media->save();

                            $model = Media::fromDb($media);
                            $model->store($movie);
                        });



                        js()->success()->closeRemoteModal();
                    }

                } catch (\Exception $e) {

                    js()->error($e->getMessage());
                }
            }
        } else {

            $data = [];
            if (preg_match('#(?<title>.+)(?<year>\d{4}).+#', $media->name, $match)) {
                $data = ['title' => $match['title'], 'year' => $match['year']];
            } else {
                $data = ['title' => $media->name];
            }

            $form->populate($data);
        }

        return response()->modal($form);
    }


    /**
     *
     *
     *
     */
    public function tvshows()
    {

        $medias = Medias::where('status_rid', \Ref::MEDIA_STATUS_STORED)
            ->where('type_rid', \Ref::MEDIA_TYPE_TVSHOW)
            ->orderBy('stored_at', 'desc')
            ->limit(50)
            ->get();

        return view('media.tvshows', compact('medias'));
    }


    /**
     * Download File
     *
     * @param $media
     */
    public function download($media)
    {
        //VALIDATION
        $this->validate($request = $this->request(), ['__media' => 'required|exists:medias,uuid']);

        // MEDIA
        $media = Medias::findOrFail($request->get('__media'));

        header("X-Sendfile: $media->realpath");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . basename($media->storage_path) . "\"");
        return;
    }

    /**
     *
     *
     *
     */
    public function movies()
    {

        $medias = Medias::where('status_rid', \Ref::MEDIA_STATUS_STORED)
            ->where('type_rid', \Ref::MEDIA_TYPE_MOVIE)
            ->orderBy('stored_at', 'desc')
            ->limit(50)
            ->get();

        return view('media.movies', compact('medias'));
    }


    /**
     *
     */
    public function direct(Request $request)
    {

        // FORMULAIRE
        $form = form()->enableRemote();
        $form->setLegend('Ajouter un téléchargement direct');
        $form->addText('url', 'URL')->addAttribute('autofocus', 'autofocus')->addLaravelValidator('url|unique:downloads,url');
        $form->addSubmit('Télécharger');


        // TRAITEMENT
        if ($request->isMethod('POST')) {

            $form->valid($request->all());

            if ($form->isValid()) {
                try {

                    // MODEL
                    Downloads::create([
                        'url' => $request->get('url'),
                        'status_rid' => \Ref::DOWNLOADS_STATUS_CREATED
                    ]);

                    js()->success()->closeRemoteModal();

                } catch (\Exception $e) {
                    js()->error($e->getMessage());
                }
            }
        }

        return response()->modal($form);
    }

}
