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

        $content = [];

        // Repertoires
        foreach (Storage::directories($directory) as $dir) {

            $basename = substr($dir, strlen($directory));
            if ($basename{0} == '.') {continue;}

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
                'url' => sprintf('javascript:fileDelete("%s", "%s")', $basename, action('FileController@getDelete', base64_encode($file)))
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
    public function getDownload(Request $request)
    {

        $file = base64_decode($request->get('f', ''));

        $file = env('XSENDFILE_ROOT') . DIRECTORY_SEPARATOR . base64_decode($file);
        $basename = substr($file, strrpos($file, '/') + 1 );
        header("X-Sendfile: $file");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$basename\"");
        return;

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
