<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite, Auth;
use Models\Business;

class AuthController extends Controller
{

    /**
     * Connect user from google API
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function facebook()
    {




//        d(request()->all());


        if (request()->has('code')) {

            /** @var \Laravel\Socialite\Two\User $user */
            $user = Socialite::driver('facebook')->user();


            // verify informations
            if (empty($user->user['verified'])) {
                throw new \Exception('User is not verified');
            }


            \DB::transaction(function() use ($user) {
                Business\User::loginWithFacebook($user->getEmail(), $user->getName(), $user->getAvatar());
            });


            if (!Auth::check()) {
                throw new \Exception('An error occur during authentification');
            }


            return redirect()->route('home');

        } else {
            return Socialite::driver('facebook')->scopes(['email','public_profile'])->redirect();
        }

        /*
        $auth = OAuth::consumer('google');

        // Response from google
        if ($code = Input::get('code')){

            // create a token (we don't need it at the time)
            $auth->requestAccessToken($code);

            $result = json_decode($auth->request('userinfo'), true);

            // verify informations
            if (empty($result['verified_email'])) {
                throw new \Exception('Email is not verified');
            }

            if (empty($result['hd']) || in_array($result['hd'], config('auth.google.hd')) === false) {
                throw new \Exception('Email is not from an available domain');
            }

            \DB::transaction(function() use ($result) {
                Business\User::loginWithGoogle($result['email'], $result['name'], $result['picture'], true);
            });


            if (!Auth::check()) {
                throw new \Exception('An error occur during authentification');
            }


            return redirect()->route('home');
        } else {
            return redirect()->away((string) $auth->getAuthorizationUri());
        }
        */

        return 'tu y es';
    }

}
