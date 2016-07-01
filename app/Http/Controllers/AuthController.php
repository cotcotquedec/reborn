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
    }

}