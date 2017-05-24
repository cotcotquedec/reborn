<?php namespace App\Http\Controllers;

use FrenchFrogs\Core\FrenchFrogsController;

/**
 * Coucou les amis
 *
 * Class DevController
 * @package App\Http\Controllers\Inside
 */
class DevController extends Controller
{

    use FrenchFrogsController;

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
    public function script($text = '')
    {
        return 'Are you happy with your script';
    }
}