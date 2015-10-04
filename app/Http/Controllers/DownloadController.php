<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{

    /**
     *
     */
    public function getIndex()
    {
        return view('download');
    }



    /**
     *
     * Launch a download job from an url
     *
     */
    public function postDirectDownload(Request $request)
    {


        dd($request->all());


    }

}
