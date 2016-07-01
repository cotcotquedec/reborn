<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use FrenchFrogs\Acl\Acl;

class CreateDefaultInterfaceAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Acl::createDatabaseInterface(Acl::INTERFACE_DEFAULT, 'Reborn');
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
