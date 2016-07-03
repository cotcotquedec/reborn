<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Models\Acl;

/**
 */
class FileController extends Controller
{

    /**
     * @name Artisan
     * @generated 2016-07-03 09:26:05
     * @see php artisan ffmake:action
     */
    public function getIndex()
    {
        \ruler()->check(
            Acl::PERMISSION_FILE
        );


        return basic('_TITRE_', '_CONTENT_');
    }

    /**
     * @name Artisan
     * @generated 2016-07-03 09:34:18
     * @see php artisan ffmake:action
     */
    public function postUpload()
    {
        \ruler()->check(
            Acl::PERMISSION_FILE_UPLOAD
        );

        $form = \form()->enableRemote();
        $form->setLegend('Téléchargement direct');
        $form->addText('link', 'Lien')->addValidator('url');
        $form->addSubmit('Télécharger');

        // Traitement
        if (request()->has('Télécharger')) {
            $form->valid(request()->all());
            if ($form->isValid()) {
                $data = $form->getFilteredValues();
                try {
                    $this->dispatch(new \App\Jobs\DirectDownload($data['link']));
                    \js()->success()->closeRemoteModal();
                } catch(\Exception $e) {
                    \js()->error($e->getMessage());
                }
            }
        }
        
        return response()->modal($form);
    }
}