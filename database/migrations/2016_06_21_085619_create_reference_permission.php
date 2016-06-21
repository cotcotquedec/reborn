<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Models\Acl;

class CreateReferencePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Acl::createDatabasePermission(Acl::PERMISSION_REFERENCE, Acl::PERMISSION_GROUP_ADMIN, Acl::INTERFACE_DEFAULT, 'Références');
        Acl::createDatatabaseNavigation('admin.reference', Acl::INTERFACE_DEFAULT, '3. Références', '/reference', Acl::PERMISSION_REFERENCE, 'admin');
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
