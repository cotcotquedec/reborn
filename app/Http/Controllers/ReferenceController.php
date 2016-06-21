<?php namespace App\Http\Controllers;


use Models\Acl;

class ReferenceController extends Controller
{
    use \FrenchFrogs\Reference\Http\Controllers\ReferenceController;

    /**
     * Overload constructor to configure ACL trait
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->permission = Acl::PERMISSION_REFERENCE;
    }
}