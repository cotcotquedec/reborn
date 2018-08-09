<?php
/**
 * Created by PhpStorm.
 * User: jhouvion
 * Date: 30/05/17
 * Time: 13:17
 */

namespace App\Http\Controllers;


use App\Models\Db\Medias;
use App\Models\Db\Users\Users;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class DefaultController extends Controller
{

    use AuthenticatesUsers;


    /**
     *
     * Home d'alliwant
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $medias = Medias::where('status_rid', '!=', \Ref::MEDIA_STATUS_STORED)->get();
        return view('files', compact('medias'));
    }


    /**
     * Entrypoint
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View|mixed
     */
    public function auth(Request $request)
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

            if ($facebook->id) {


                $user = Users::where('facebook_id', $facebook->id)->first() ?: user();

                // si uyser pas connecté
                if (is_null($user)) {
                    abort(401, 'Vous n\'avez pas accès a cette plateforme, merci de contacter un admin');
                }

                // mise a jour de l'id facebook
                if ($facebook->id != $user->facebook_id) {
                    $user->update(['facebook_id' => $facebook->id]);
                }

                // on force la deconnexion
                auth()->logout();

                // on se log
                auth()->loginUsingId($user->getKey(), true);
            }
            return redirect(\Auth::check() ? route('home') : route('login'));
        } else {
            return \Socialite::driver('facebook')->scopes(['public_profile'])->redirect();
        }
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


}