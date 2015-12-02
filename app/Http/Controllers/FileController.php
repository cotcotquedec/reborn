<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;

class FileController extends Controller
{

    /**
     *
     * Liste le contenu d'un repertoire
     *
     * @return \Illuminate\View\View
     */
    public function getIndex(Request $request)
    {
        $directory = base64_decode($request->get('d', ''));
        $directory = empty($directory) ? 'download' : $directory;
        $content = [];

        // Repertoires
        foreach (Storage::directories($directory) as $dir) {

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


        // Fichiers
        foreach (Storage::files($directory) as $file) {

            $basename = substr($file, strlen($directory));
            if ($basename{0} == '.') {continue;}
            if ($basename{0} == '/') {$basename = substr($basename, 1);}

            $options = [];

            if ( Storage::exists($file)){

                if (in_array(substr($basename, strrpos($basename, '.')), ['.avi', '.mkv', '.mp4'])) {

                    //@todo sort a tvshow
                    $options[] = [
                        'title'=>'Trier série',
                        'icon' => 'fa fa-video-camera',
                        'class' => 'btn btn-sm btn-success',
                        'url' => action('FileController@getDownload', ['f' => base64_encode($file)])
                    ];

                    // @todo sort a movie
                    $options[] = [
                        'title'=>'Trier film',
                        'icon' => 'fa fa-film',
                        'class' => 'btn btn-sm btn-success',
                        'url' => action('FileController@getDownload', ['f' => base64_encode($file)])
                    ];
                }

                $options[] = [
                    'title'=>'Télécharger',
                    'icon' => 'fa fa-download',
                    'class' => 'btn btn-sm btn-primary',
                    'url' => action('FileController@getDownload', ['f' => base64_encode($file)])
                ];
            }


            $options[] = [
                'title'=>'Supprimer',
                'icon' => 'fa fa-trash-o',
                'class' => 'btn btn-sm btn-danger',
                'url' => sprintf('javascript:fileDelete("%s", "%s")', $basename, action_url(__CLASS__, 'getDelete', base64_encode($file)))
            ];
            $content[] = ['name' => $basename, 'type' => 'file', 'size' => human_size(Storage::size($file)), 'options' => $options];
        }

        return view('file.index', compact(['content']));
    }

    /**
     * Download a file
     *
     * @param $file
     */
    public function getDownload($file)
    {
        $file = env('XSENDFILE_ROOT') . DIRECTORY_SEPARATOR . base64_decode($file);

        $basename = substr($file, strrpos($file, '/') + 1 );
        header("X-Sendfile: $file");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$basename\"");
        return;

    }


    /**
     * Launch a download job from an url
     *
     * @return mixed
     */
    public function postDirectDownload()
    {
        $form = form()->enableRemote();
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
                    js()->success()->closeRemoteModal();
                } catch(\Exception $e) {
                    js()->error($e->getMessage());
                }
            }
        }

        return response()->modal($form);
    }

    /**
     * Upload a torrent file
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postTorrent(Request $request)
    {

        $form = form()->enableRemote();
        $form->setLegend('Torrent');
        $form->addFile('torrent', 'File');
        $form->addSubmit('Uploader');


        if (request()->has('Uploader')) {
            $form->valid(request()->all());
            if ($form->isValid()) {
                $data = $form->getFilteredValues();
                try {

                    // recupération du fichier
                    $file = $data['torrent'];

                    // recuperation du nom du fichier
                    $name = $file->getClientOriginalName();

                    // on deplace le fichier
                    $file->move(config('filesystems.disks.torrent.root'),$name);

                    // on verifie que le fichier exist
                    if (!\Storage::drive('torrent')->exists($name)) {
                        throw new \Exception('Erreur sur l\'upload du fichier');
                    }
                    js()->success()->closeRemoteModal();
                } catch(\Exception $e) {
                    js()->error($e->getMessage());
                }
            }
        }


        return response()->modal($form);

//        try {
//
//            // on veifie que le fichier est bien la
//            $file  = $request->file('torrent');
//            if (!$file->isValid()) {
//                throw new \Exception('Erreur sur l\'upload du fichier');
//            }
//
//            // recuperation du nom du fichier
//            $name = $file->getClientOriginalName();
//
//            // on deplace le fichier
//            $file->move(config('filesystems.disks.torrent.root'),$name);
//
//            // on verifie que le fichier exist
//            if (!\Storage::drive('torrent')->exists($name)) {
//                throw new \Exception('Erreur sur l\'upload du fichier');
//            }
//
//            js()->success('Torrent envoyé');
//        } catch(\Exception $e) {
//            js()->error($e->getMessage());
//        }
//
//        return redirect()->action('DownloadController@getIndex');
    }


    /**
     * Suppression d'un repertoire
     *
     * @param $directory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDeleteDirectory($directory)
    {
        $directory = base64_decode($directory);

        if (Storage::exists($directory)) {
            Storage::deleteDirectory($directory);
        }

        return redirect()->back();
    }


    /**
     * Suppression d'un fichier
     *
     * @param $file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($file)
    {

        $file = base64_decode($file);

        if (Storage::exists($file)) {
            Storage::delete($file);
        }

        return redirect()->back();
    }

}
