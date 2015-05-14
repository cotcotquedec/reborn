<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Storage;

use Illuminate\Http\Request;

class FileController extends Controller {

	public function index()
    {
        $content = [];

        foreach (Storage::directories() as $dir) {

//            $content[] = ['name' => $dir, 'icon' => ''];
//            Storage::
//            dd($dir);
        }


        $files = Storage::files();
        $directories = Storage::directories();
        return view('file.index', compact(['files', 'directories']));
    }

}
