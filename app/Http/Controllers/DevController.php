<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use FrenchFrogs\Acl\Acl;
use FrenchFrogs\Models\Reference;
use FrenchFrogs\Laravel\Database\Schema\Blueprint;

class DevController extends Controller
{

    public function layout()
    {
//        date(strtotime(rand(0, )))
    }


    public function script()
    {


//        dd(rand(0, time()));
        dd(date('Y-m-d', rand(0, time())));
        
        dd(\Hash::check('sandrine', '$2y$13$gku3q3qfz6gc4wokcs0kcuVAR7CcW3CXgSM8yPO54D.1eexP9HfSW'));


//        dd(bcrypt('sandrine'));
        return 'Are you happy with your script';
    }
}