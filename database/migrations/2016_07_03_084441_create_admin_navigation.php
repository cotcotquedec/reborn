<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Models\Acl;

class CreateAdminNavigation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // permissions
        Acl::createDatabasePermissionGroup(Acl::PERMISSION_GROUP_ADMIN, 'Groupe administrattion');
        Acl::createDatabasePermission(Acl::PERMISSION_ADMIN, Acl::PERMISSION_GROUP_ADMIN, Acl::INTERFACE_DEFAULT, 'Administrattion');
        Acl::createDatabasePermission(Acl::PERMISSION_USER, Acl::PERMISSION_GROUP_ADMIN, Acl::INTERFACE_DEFAULT, 'Utilisateurs');
        Acl::createDatabasePermission(Acl::PERMISSION_SCHEDULE, Acl::PERMISSION_GROUP_ADMIN, Acl::INTERFACE_DEFAULT, 'Tâches planifiées');


        // navigation
        Acl::createDatatabaseNavigation('admin',Acl::INTERFACE_DEFAULT, 'Administration', 'javascript:;', Acl::PERMISSION_ADMIN);
        Acl::createDatatabaseNavigation('admin.user',Acl::INTERFACE_DEFAULT, '1. Utilisateurs', '/user', Acl::PERMISSION_USER, 'admin');
        Acl::createDatatabaseNavigation('admin.schedule',Acl::INTERFACE_DEFAULT, '2. Tâches planifiées', '/schedule', Acl::PERMISSION_SCHEDULE, 'admin');

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
