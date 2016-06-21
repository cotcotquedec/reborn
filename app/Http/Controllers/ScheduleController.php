<?php namespace App\Http\Controllers;


use Models\Acl;

class ScheduleController extends Controller
{
    use \FrenchFrogs\Scheduler\Http\Controllers\ScheduleController;

    /**
     * Overload constructor to configure ACL trait
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->permission = Acl::PERMISSION_SCHEDULE;
    }
}