<?php namespace Models;


use FrenchFrogs\Ruler\Ruler\Ruler;

class Acl extends Ruler
{

    const PERMISSION_CONTRIBUTOR = 'user.is_contributor';
    const PERMISSION_ACTIVE= 'user.is_active';
    const PERMISSION_ADMIN = 'user.is_admin';

    /**
     * Easy validation
     *
     * @param array $permissions
     * @param array $laravelValidator
     * @param bool|false $throwException
     * @return bool
     * @throws \Exception
     */
    public function check($permissions = [], $laravelValidator = [], $request = null, $throwException = true)
    {
        try {
            // permission
            foreach ((array)$permissions as $permission) {
                if (!$this->hasPermission($permission)) {
                    abort(401, 'You don\'t have the right permissions');
                }
            }
            // request validation
            $request = is_null($request) ? request()->all() : $request;
            $validation = \Validator::make($request, $laravelValidator);
            if ($validation->fails()) {
                abort(404, 'Parameters are not valid');
            }
        }catch (\Exception $e) {
            if ($throwException) {throw $e;}
            return false;
        }
        return true;
    }

}