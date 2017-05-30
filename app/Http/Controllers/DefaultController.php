<?php
/**
 * Created by PhpStorm.
 * User: jhouvion
 * Date: 30/05/17
 * Time: 13:17
 */

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class DefaultController extends Controller
{

    use AuthenticatesUsers;



    public function index()
    {

        return 'OK';
    }

    /**
     * Entrypoint
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View|mixed
     */
    public function login(Request $request)
    {
        // si deja connecter on redirige
        if ($this->guard()->check()) {
            return $this->authenticated($request, $this->guard()->user());
        }

        // si post de formulaire on effctue le traitement
        // sinon on affiche le formulaire
        return $request->isMethod('POST') ? $this->login($request) : $this->showLoginForm();
    }


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // redirection sur la page d'accueil
        return response()->redirectToRoute('home');
    }

    /**
     * Affichage du formulaire de login
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }



    /**
     *
     * Connection a facebook
     *
     */
    public function facebook()
    {

        $request = $this->request();

        if ($request->has('code')) {
            /** @var \Laravel\Socialite\Two\User $user */
            $facebook = \Socialite::driver('facebook')->user();
            if ($facebook->user['verified']) {


                dd($facebook);


                //@todo create user
//
                auth()->loginUsingId($user->getKeu(), true);
            }
            return redirect(\Auth::check() ? route('home') : route('login'));
        } else {
            return \Socialite::driver('facebook')->scopes(['public_profile'])->redirect();
        }
    }


}