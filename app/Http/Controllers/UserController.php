<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use FrenchFrogs\Acl\Http\Controllers\AclController;
use Models\Business\User;

/**
 * Class UserController
 *
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    use AclController;


    /**
     * Overload constructor to configure ACL trait
     *
     * UserController constructor.
     */
    public function __construct()
    {
//        $this->user_permission = User::PERMISSION_USER;
    }


    /**
     * Page d'accueil
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        return view('home');
    }
}
