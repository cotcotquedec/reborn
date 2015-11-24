<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session, Input;

class DownloadController extends Controller
{
    /**
     *
     */
    public function getIndex()
    {
        $link = form()->enableCallback();
        $link->setUrl(action_url(__CLASS__, 'postDirectDownload'));
        $link->useDefaultPanel('Téléchargement direct');
        $link->addText('direct-link', 'Lien');
        $link->addSubmit('Télécharger');

        return view('download', compact('link'));
    }



    /**
     *
     * Launch a download job from an url
     *
     */
    public function postDirectDownload()
    {

        try {

            if (!request()->has('direct-link')) {
                throw new \Exception('Le lien est obligatoire');
            }

            // lancement du telechargement
            $this->dispatch(new \App\Jobs\DirectDownload(request()->get('direct-link')));

            js()->success('Le téléchargement est lancé');
        } catch(\Exception $e) {
            js()->error($e->getMessage());
        }

        return js();
    }


    public function postTorrent(Request $request)
    {

        try {

            // on veifie que le fichier est bien la
            $file  = $request->file('torrent');
            if (!$file->isValid()) {
                throw new \Exception('Erreur sur l\'upload du fichier');
            }

            // recuperation du nom du fichier
            $name = $file->getClientOriginalName();

            // on deplace le fichier
            $file->move(config('filesystems.disks.torrent.root'),$name);

            // on verifie que le fichier exist
            if (!\Storage::drive('torrent')->exists($name)) {
                throw new \Exception('Erreur sur l\'upload du fichier');
            }

            js()->success('Torrent envoyé');
        } catch(\Exception $e) {
            js()->error($e->getMessage());
        }

        return redirect()->action('DownloadController@getIndex');
    }

}
