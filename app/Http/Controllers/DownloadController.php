<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session, Input;

class DownloadController extends Controller
{

    const FLASH_DDL_SUCCESS = 'ddl-success';

    /**
     *
     */
    public function getIndex()
    {

        $error = $success = '';


        // Direct download
        if (Session::has(static::FLASH_DDL_SUCCESS)) {
            if (Session::get(static::FLASH_DDL_SUCCESS)) {
                $success  = 'Votre fichier a bien été ajouté à la file de téléchargement';
            } else {
                $error = 'Une erreur est survenue pendant l\'ajoue de votre téléchargement';
            }
        }

        // Formulaire
        $form = form();
        $form->addText('name', 'Nom');
        $form->addLabel('email', 'Email');
        $form->addSubmit('Enregistrer');
        $form->enableRemote();
        if (!$is_creation) {
            $user = User::get($id)->toArray();
            $form->setLegend('Utilisateur : ' . $user['name']);
        } else {
            $form->setLegend('Utilisateurs');
        }
        // enregistrement
        if (Request::has('Enregistrer')) {
            dd('OKI');
            // default
        } elseif(!$is_creation){
            $form->populate($user);
        }


        return view('download', compact('error', 'success'));
    }



    /**
     *
     * Launch a download job from an url
     *
     */
    public function postDirectDownload(Request $request)
    {

        try {
            if (!$request->has('direct-link')) {
                throw new \Exception('Paramètre incorrect');
            }

            $this->dispatch(new \App\Jobs\DirectDownload($request->get('direct-link')));
            $request->session()->flash(static::FLASH_DDL_SUCCESS, true);

        } catch(\Exception $e) {
            $request->session()->flash(static::FLASH_DDL_SUCCESS, false);
        }

        return redirect()->action('DownloadController@getIndex');
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
        } catch(\Exception $e) {
            $request->session()->flash(static::FLASH_DDL_SUCCESS, false);
        }

        return redirect()->action('DownloadController@getIndex');
    }

}
