<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Models\Acl;
use Storage;

/**
 */
class FileController extends Controller
{

    /**
     * @name Artisan
     * @generated 2016-07-03 10:05:16
     * @see php artisan ffmake:action
     */
    public function deleteFile($id)
    {
        //RULER
        \ruler()->check(
            Acl::PERMISSION_FILE_UPLOAD
        );

        // on charge le repertoire
        $storage = Storage::drive('files');

        //@todo créer les validator necessaire!!
        $file = base64_decode($id);
        if (empty($file) || !$storage->exists($file)) {
            abort('404');
        }

        // MODAL
        $modal = \modal(null, 'Etes vous sûr de vouloir supprimer : <b>' . basename($file) . '</b>');
        $button = (new \FrenchFrogs\Form\Element\Button('yes', 'Supprimer !'))
            ->setOptionAsDanger()
            ->enableCallback('delete')
            ->addAttribute('href', request()->url() . '?delete=1');
        $modal->appendAction($button);

        // TRAITEMENT
        if (\request()->has('delete')) {
            try {
                $storage->delete($file);
                \js()->success()->closeRemoteModal()->reload();
            } catch (\Exception $e) {
                \js()->error($e->getMessage());
            }
            return js();
        }

        return response()->modal($modal);
    }

    /**
     * @name Artisan
     * @generated 2016-07-03 09:26:05
     * @see php artisan ffmake:action
     * @param Request $request
     */
    public function getIndex(Request $request)
    {
        \ruler()->check(
            Acl::PERMISSION_FILE
        );

        $directory = base64_decode($request->get('d', ''));
        $directory = empty($directory) ? 'downloads' : $directory;
        $content = [];

        // on charge le repertoire
        $storage = Storage::drive('files');

        // @todo Repertoires
        /*
        foreach ($storage->directories($directory) as $dir) {
            $basename = substr($dir, strlen($directory));
            if ($basename{0} == '.') {continue;}
            if ($basename{0} == '/') {$basename = substr($basename, 1);}
            $options = [];
            $options[] = [
                'title'=> 'Ouvrir',
                'icon' => 'fa fa-folder-open',
                'class' => 'btn btn-sm btn-primary',
                'url' => action('FileController@getIndex', ['d' => base64_encode($dir)])
            ];


            $options[] = [
                'title'=> 'Supprimer',
                'icon' => 'fa fa-trash-o',
                'class' => 'btn btn-sm btn-danger',
                'url' => sprintf('javascript:fileDelete("%s", "%s")', $basename, action('FileController@getDeleteDirectory', ['d' => base64_encode($dir)]))];
            $content[] = ['name' => $basename, 'type' => 'directory', 'options' => $options];
        }
        */


        // Fichiers
        foreach ($storage->files($directory) as $file) {

            $basename = substr($file, strlen($directory));
            if ($basename{0} == '.') {
                continue;
            }

            if ($basename{0} == '/') {
                $basename = substr($basename, 1);
            }

            $options = [];
            if ($storage->exists($file)) {
                /*
                if (in_array(substr($basename, strrpos($basename, '.')), ['.avi', '.mkv', '.mp4'])) {
                    //@todo sort a tvshow
                    $options[] = [
                        'title' => 'Trier série',
                        'icon' => 'fa fa-video-camera',
                        'class' => 'btn btn-sm btn-success',
                        'url' => action_url(static::class, 'getDownload', ['f' => base64_encode($file)])
                    ];
                    // @todo sort a movie
                    $options[] = [
                        'title' => 'Trier film',
                        'icon' => 'fa fa-film',
                        'class' => 'btn btn-sm btn-success',
                        'url' => action_url(static::class, 'getDownload', ['f' => base64_encode($file)])
                    ];
                }

                // @todo download
                $options[] = [
                    'title' => 'Télécharger',
                    'icon' => 'fa fa-download',
                    'class' => 'btn btn-sm btn-primary',
                    'url' => action_url(static::class, 'getDownload', ['f' => base64_encode($file)])
                ];
                */
            }

            $content[] = ['id' => base64_encode($file), 'name' => $basename, 'type' => 'file', 'size' => human_size($storage->size($file)), 'options' => $options];
        }

        // TABLE
        $table = \table($content);
        $table->useDefaultPanel('Fichiers');

        // COLUMN
        $table->addText('name', 'Nom');
        $table->addText('size', 'Taille')->right();

        // ACTION
        $action = $table->addContainer('action', '');
        $action->addButtonDelete(action_url(static::class, 'deleteFile', '%s'), 'id');


        return basic('Fichiers', $table);
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
                } catch (\Exception $e) {
                    \js()->error($e->getMessage());
                }
            }
        }

        return response()->modal($form);
    }
}