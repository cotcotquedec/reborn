<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Models\Acl;

class CreateNavigationPartenaire extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // permissions
        Acl::createDatabasePermissionGroup(Acl::PERMISSION_GROUP_PARTNER, 'Groupe partenaire');
        Acl::createDatabasePermission(Acl::PERMISSION_PARTNER, Acl::PERMISSION_GROUP_PARTNER, Acl::INTERFACE_DEFAULT, 'Partenaires');
        Acl::createDatabasePermission(Acl::PERMISSION_PARTNER_VOUCHER, Acl::PERMISSION_GROUP_PARTNER, Acl::INTERFACE_DEFAULT, 'Code Promo');

        // navigation
        Acl::createDatatabaseNavigation('partner',Acl::INTERFACE_DEFAULT, '2. Partenaires', 'javascript:;', Acl::PERMISSION_PARTNER);
        Acl::createDatatabaseNavigation('partner.index',Acl::INTERFACE_DEFAULT, '1. Partenaires', '/partner', Acl::PERMISSION_PARTNER, 'partner');
        Acl::createDatatabaseNavigation('partner.voucher',Acl::INTERFACE_DEFAULT, '2. Code Promo', '/partner/voucher', Acl::PERMISSION_PARTNER_VOUCHER, 'partner');
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
