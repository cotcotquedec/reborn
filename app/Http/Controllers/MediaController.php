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
        $form->addText('title', 'Titre')->addAttribute('autofocus', 'autofocus')->validator('min:3');
        $form->addNumber('year', 'Année', false)->validator('size:4');
        $form->addSubmit('Chercher');

        // TRAITEMENT
        if ($request->isMethod('POST')) {

            if ($data = $form->valid($request->all())) {




                try {


                    // Recherche de film
                    if (!data_get($data, 'movie_id')) {
                        // recherche
                        $search = \Tmdb::getSearchApi()->searchMovies(data_get($data, 'title'), ['year' => data_get($data, 'year')]);
                        $movies = [];

                        if (!empty($search['total_results'])) {

                            foreach ($search['results'] as $row) {

                                $title = $row['title'];

                                if (!empty($row['release_date'])) {
                                    $title .= sprintf(' (%d)', substr($row['release_date'], 0, 4));
                                }

                                $movies[$row['id']] = $title;
                            }

                            $form->addSelect('movie_id', 'Film', $movies)->setPlaceholder();
                        }
                    } else {

                        transaction(function () use ($data, $media) {
                            // STOCKAGE
                            $movie = data_get($data, 'movie_id');
                            $infos = \Tmdb::getMoviesApi()->getMovie($movie);

                            // Synchro avec la base
                            $media->search_info = [$movie => ['movie' => $infos]];
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
    public function tvshows(Request $request)
    {

        $medias = Medias::where('status_rid', \Ref::MEDIA_STATUS_STORED)
            ->where('type_rid', \Ref::MEDIA_TYPE_TVSHOW)
            ->orderBy('stored_at', 'desc');

        // Traitement de la recherche
        if ($q = $request->get('q', false)) {
            $medias->where('data->tvshow->data->name', 'like', '%'.$q.'%');
        }

        $medias = $medias->paginate(24);
        !empty($q) && $medias->appends(compact('q'));

        return view('media.tvshows', compact('medias', 'q'));
    }


    /**
     * Supression d'un media
     *
     * @param $media
     * @return \FrenchFrogs\Container\Javascript
     */
    public function delete($media)
    {
        //VALIDATION
        $this->validate($request = $this->request(), ['__media' => 'required|exists:medias,uuid']);

        // MEDIA
        $media = Medias::findOrFail($request->get('__media'));

        // MODAL
        $modal = \modal(null, 'Etes vous sûr de vouloir supprimer : <b>' . $media->name . '</b>');
        $button = (new \FrenchFrogs\Form\Element\Button('yes', 'Supprimer !'))
            ->setOptionAsDanger()
            ->enableCallback('get')
            ->addAttribute('href', url()->clone()->withQuery(['delete' => true])->current());
        $modal->appendAction($button);

        // TRAITEMENT
        if ($request->has('delete')) {
            try {

                if (!\Storage::disk('files')->exists($media->storage_path)) {
                    $media->delete();
                } else {
                    Media::fromDb($media)->delete();
                }

                \js()->success()->closeRemoteModal()->appendJs('#' . $request->get('media'), 'detach');
            } catch (\Exception $e) {
                \js()->error($e->getMessage());
            }
            return js();
        }

        return response()->modal($modal);
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
    public function movies(Request $request)
    {
        $medias = Medias::where('status_rid', \Ref::MEDIA_STATUS_STORED)
            ->where('type_rid', \Ref::MEDIA_TYPE_MOVIE)
            ->orderBy('stored_at', 'desc');

        if ($q = $request->get('q', false)) {
            $medias->where('data->movie->title', 'like', '%'.$q.'%');
        }

        $medias = $medias->paginate(24);
        !empty($q) && $medias->appends(compact('q'));

        return view('media.movies', compact('medias','q'));
    }


    /**
     *
     *
     * @param $query
     */
    public function search(Request $request)
    {

        $medias = null;
        if ($request->has('q')) {
            $query = $request->get('q');
            $medias = Medias::search($query)->raw();
        }

        return view('media.search', compact('medias'));
    }


    /**
     *
     */
    public function direct(Request $request)
    {
        // FORMULAIRE
        $form = form()->enableRemote();
        $form->setLegend('Ajouter un téléchargement direct');
        $form->addText('url', 'URL')
            ->addAttribute('autofocus', 'autofocus')
            ->validator('url|unique:downloads,url');
//        $form->addSubmit('Télécharger');


        try {
            $form->addSubmit('Télécharger')
                ->setProcess(function ($values) {
                    return transaction(function () use ($values) {

                        // MODEL
                        Downloads::create([
                            'url' => $values['url'],
                            'status_rid' => \Ref::DOWNLOADS_STATUS_CREATED
                        ]);

                        js()->closeRemoteModal();
                        return true;
                    });
                });
        } catch (\Throwable $e) {
            debugbar()->addThrowable($e);
        }

        return $form;
    }

}
