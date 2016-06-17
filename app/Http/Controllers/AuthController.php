<?php namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use OAuth, Auth;
use Input;
use Models\Business;
use Request;

class AuthController extends Controller
{
    /**
     * Connect user from google API
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function google(/*Request $request*/)
    {
        $auth = OAuth::consumer('google');

        // Response from google
        if ($code = Input::get('code')){

            //create a token (we don't need it at the time)
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
            
            return redirect()->route('home');
        } else {
            return redirect()->away((string) $auth->getAuthorizationUri());
        }
    }
}
