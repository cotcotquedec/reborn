<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Storage, Redirect;

use Illuminate\Http\Request;

class FileController extends Controller {


    /**
     *
     * Liste le contenu d'un repertoire
     *
     * @param null $directory
     * @return \Illuminate\View\View
     */
	public function index($directory = '')
    {

        $content = [];

        $directory = !empty($directory) ? base64_decode($directory) . DIRECTORY_SEPARATOR : '';

        // Repertoires
        foreach (Storage::directories($directory) as $dir) {

            $basename = substr($dir, strlen($directory));
            if ($basename{0} == '.') {continue;}

            $options = [];
            $options[] = ['title'=> 'Ouvrir', 'icon' => 'fa fa-folder-open', 'class' => 'btn btn-sm btn-primary', 'url' => route('file-list', base64_encode($dir))];
            $options[] = ['title'=> 'Supprimer', 'icon' => 'fa fa-trash', 'class' => 'btn btn-sm btn-danger', 'url' => sprintf('javascript:fileDelete("%s", "%s")', $basename, route('file-deldir', [base64_encode($dir)]))];

            $content[] = ['name' => $basename, 'type' => 'directory', 'options' => $options];
        }


        // Fichiers
        foreach (Storage::files($directory) as $file) {

            $basename = substr($file, strlen($directory));
            if ($basename{0} == '.') {continue;}

            $options = [];


            $icon = '';
            if (in_array(substr($basename, strrpos($basename, '.')), ['.avi', '.mkv', '.mp4'])) {
                 $options[] = ['title'=>'Trier', 'icon' => 'fa fa-archive', 'class' => 'btn btn-sm btn-success', 'url' => '#'];
            }
            $options[] = ['title'=>'Télécharger', 'icon' => 'fa fa-download', 'class' => 'btn btn-sm btn-primary', 'url' => '#'];
            $options[] = ['title'=>'Supprimer', 'icon' => 'fa fa-trash-o', 'class' => 'btn btn-sm btn-danger', 'url' => sprintf('javascript:fileDelete("%s", "%s")', $basename, route('file-del', base64_encode($file)))];
            $content[] = ['name' => $basename, 'type' => 'file', 'options' => $options];
        }

        return view('file.index', compact(['content']));
    }


    /**
     * Suppression d'un repertoire
     *
     * @param $directory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDirectory($directory)
    {
        $directory = base64_decode($directory) . DIRECTORY_SEPARATOR;

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
    public function delete($file)
    {
        $file = base64_decode($file);

        if (Storage::exists($file)) {
            Storage::delete($file);
        }

        return redirect()->back();
    }
}
