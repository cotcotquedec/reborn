<?php namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use FrenchFrogs\Acl\Acl;
use Models\Business;
use Illuminate\Http\Request;
use Auth;

/**
 * Controller d'authentification
 *
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{

    /**
     *
     * Page d'authentification
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        $error = false;
        $email = '';

        if ($request->has('email')) {
            $error = true;
            $email = $request->get('email');
            $password = $request->get('password');

            //Authentification
//            if (Auth::attempt(['email' => $email, 'password' => $password, 'user_interface_id' => Acl::INTERFACE_DEFAULT], true)) {
//                Auth::user()->update(['loggedin_at' => Carbon::now()]);
//            }
//            Auth::loginUsingId(hex2bin('fd81bfa9ef404a9c9acdb6162c24cecd'));
        }

        return Auth::check() ? redirect()->route('home') : view('login', ['error' => $error, 'email' => $email]);
    }
}
