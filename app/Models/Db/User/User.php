<?php namespace Models\Db\User;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends  \FrenchFrogs\Models\Db\User\User  implements AuthenticatableContract  {
    use Authenticatable;
}

