<?php namespace Models\Business;


use FrenchFrogs\Models\Db;
use Auth;
class User extends \FrenchFrogs\Models\Business\User
{
    static protected $modelClass = Db\User\User::class;

    static public function loginWithFacebook($email, $name, $picture = false)
    {
        // update user
        $user = Db\User\User::firstOrNew(['email' => $email]);
        if (is_null($user->user_id)) {
            $model = static::create([
                'email' => $email,
                'name' => $name,
                'user_interface_id' => \Models\Acl::INTERFACE_DEFAULT
            ]);
        } else {
            $model = static::get($user->user_id);
        }

        // Authentification
        Auth::loginUsingId($model->getId('bytes'), true);
        return $model;
    }
}