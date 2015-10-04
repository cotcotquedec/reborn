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
//        $job = (new \App\Jobs\DirectDownload('http://wikipics.net/photos/20150125142221651988185.jpg'))->delay(10);

//        Queue::push('\App\Jobs\DirectDownload','http://wikipics.net/photos/20150125142221651988185.jpg');

        $this->dispatch((new \App\Jobs\DirectDownload('http://wikipics.net/photos/20150125142221651988185.jpg')));


//        $this->dispatch($job);
        //response();
        return 'Are you happy with your script';
    }


}