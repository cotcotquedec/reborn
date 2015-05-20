<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Storage, Input;
use App\Tvdb;

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

            if ( Storage::disk('xsendfile')->exists('download/' . $file)){

                if (in_array(substr($basename, strrpos($basename, '.')), ['.avi', '.mkv', '.mp4'])) {
                    $options[] = ['title'=>'Trier', 'icon' => 'fa fa-archive', 'class' => 'btn btn-sm btn-success', 'url' => route('file-classify', base64_encode('download/' . $file))];
                }

                $options[] = ['title'=>'Télécharger', 'icon' => 'fa fa-download', 'class' => 'btn btn-sm btn-primary', 'url' => route('file-download', base64_encode('download/' . $file))];
            }


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


    /**
     * Trier un contenu media
     *
     * @param $file
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function classify($file)
    {

        $file = base64_decode($file);

        $storage = Storage::disk('xsendfile');

        if (!$storage->exists($file)) {
           return redirect()->back();
        }

        $info = [];
        $info['basename'] = substr($file, strrpos($file, '/') + 1 );
        $info['mime'] = $storage->mimeType($file);
        $info['size'] = number_format($storage->size($file) / 1024 / 1024, 0, '.' , ' ');


        $result = [];
        if (Input::has('search')) {
            //$result = Tvdb::getSeries(Input::get('query'));


            $result = array ( 79349 => array ( 'name' => 'Dexter', 'id' => 79349, 'overview' => 'Brillant expert scientifique du service médico-légal de la police de Miami, Dexter Morgan est spécialisé dans l\'analyse de prélèvements sanguins. Mais voilà, Dexter cache un terrible secret : il est également tueur en série. Un serial killer pas comme les autres, avec sa propre vision de la justice.', 'banner' => 'http://thetvdb.com/banners/graphical/79349-g28.jpg', 'year' => '2006', ), 77992 => array ( 'name' => 'Le laboratoire de Dexter', 'id' => 77992, 'overview' => 'Dexter est un petit génie âgé de 8 ans possède un laboratoire ultramoderne secret derrière sa chambre et il crée de nombreuses inventions et a une soeur aînée appelé Dee Dee qui détruit tout sur son passage.', 'banner' => 'http://thetvdb.com/banners/graphical/77992-g2.jpg', 'year' => '1996', ), );
        }


        return view('file.classify', compact(['info', 'result', 'file']));
    }


    /**
     * Trie d'une serie
     *
     */
    public function classifyTvShow($file)
    {


        return $file . json_encode(Input::all());

    }
}
