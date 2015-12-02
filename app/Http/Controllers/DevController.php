<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Models\Business\Media;
use GuzzleHttp\Client;
use Models\Business;
use Auth, Storage, Queue;

class DevController extends Controller
{

    public function layout()
    {
        return view('dev');
    }


    public function script()
    {
        return 'Are you happy with your script';
    }


}