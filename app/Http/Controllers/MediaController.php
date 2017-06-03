<?php

namespace App\Http\Controllers;

use App\Models\Db\Medias;
use App\Models\Media;

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
        $medias = Medias::where('status_rid', '!=', \Ref::MEDIA_STATUS_STORED)->get();
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
     *
     *
     *
     */
    public function tvshows()
    {

        $medias = Medias::where('status_rid', \Ref::MEDIA_STATUS_STORED)
            ->where('type_rid', \Ref::MEDIA_TYPE_TVSHOW)
            ->orderBy('stored_at')
            ->get();

        return view('media.tvshows', compact('medias'));
    }


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

}
