<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Models\Acl;

class CreateFilePermissionAndNavigation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Acl::createDatabasePermissionGroup(Acl::PERMISSION_GROUP_FILE, 'Fichiers');
        Acl::createDatabasePermission(Acl::PERMISSION_FILE, Acl::PERMISSION_GROUP_FILE, Acl::INTERFACE_DEFAULT, 'Fichiers');
        Acl::createDatabasePermission(Acl::PERMISSION_FILE_UPLOAD, Acl::PERMISSION_GROUP_FILE, Acl::INTERFACE_DEFAULT, 'Upload');
        Acl::createDatabasePermission(Acl::PERMISSION_FILE_SORT, Acl::PERMISSION_GROUP_FILE, Acl::INTERFACE_DEFAULT, 'Trier');

        // navigation
        Acl::createDatatabaseNavigation('file',Acl::INTERFACE_DEFAULT, '1. Fichiers', '/file', Acl::PERMISSION_FILE);

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
