<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

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

}
