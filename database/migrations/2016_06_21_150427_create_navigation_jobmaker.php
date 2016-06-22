<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Models\Acl;

class CreateNavigationJobmaker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Acl::createDatabasePermissionGroup(Acl::PERMISSION_GROUP_JOBMAKER, 'Jobmaker');
        Acl::createDatabasePermission(Acl::PERMISSION_JOBMAKER, Acl::PERMISSION_GROUP_JOBMAKER, Acl::INTERFACE_DEFAULT, 'Jobmaker');
        Acl::createDatabasePermission(Acl::PERMISSION_JOBMAKER_USER, Acl::PERMISSION_GROUP_JOBMAKER, Acl::INTERFACE_DEFAULT, 'Utilisateurs');
        Acl::createDatatabaseNavigation('jobmaker', Acl::INTERFACE_DEFAULT, '1. Jobmaker', 'javascript:;', Acl::PERMISSION_JOBMAKER);
        Acl::createDatatabaseNavigation('jobmaker.user', Acl::INTERFACE_DEFAULT, '1. Utilisateurs', '/jobmaker', Acl::PERMISSION_JOBMAKER_USER, 'jobmaker');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
