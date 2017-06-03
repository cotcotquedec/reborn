<?php namespace App\Http\Controllers;

use Tmdb\Helper\ImageHelper;

/**
 * Coucou les amis
 *
 * Class DevController
 * @package App\Http\Controllers\Inside
 */
class DevController extends Controller
{

    /**
     *
     *
     */
    public function layout()
    {
        return view('dev');
    }


    /**
     *
     *
     */
    public function script(ImageHelper $helper)
    {
        dd(ruler());


        return 'Are you happy with your script';
    }
}