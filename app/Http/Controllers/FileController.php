<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Storage;

use Illuminate\Http\Request;

class FileController extends Controller {

	public function index()
    {
        $content = [];

        foreach (Storage::directories() as $dir) {
            $options = ['Ouvrir' => ['icon' => 'fa fa-folder-open', 'class' => 'btn btn-sm btn-primary', 'url' => '#']];
            $content[] = ['name' => $dir, 'icon' => 'fa fa-folder', 'options' => $options];
        }

        foreach (Storage::files() as $files) {
            if ($files{0} == '.') {continue;}
            $content[] = ['name' => $files, 'icon' => 'fa fa-file'];
        }

        return view('file.index', compact(['content']));
    }

}
