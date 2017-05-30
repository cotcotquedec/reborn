<?php

use FrenchFrogs\Laravel\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use FrenchFrogs\Laravel\Support\Facades\Schema;

class CreateAclTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $this->down();

        /**
         * Table de référence des interfaces
         *
         */
        Schema::create('users_interfaces', function(Blueprint $table){
            $table->stringId('sid');
            $table->string('name');
            $table->softDeletes();
        });

        /**
         * Table de référence des groupe d'utilisateurs
         *
         */
        Schema::create('users_groups', function(Blueprint $table){
            $table->binaryUuid('uuid');
            $table->string('name');
            $table->softDeletes();
        });

        /**
         * Table de référence des groupes de permissions
         *
         */
        Schema::create('users_permissions_groups', function (Blueprint $table) {
            $table->stringId('sid');
            $table->string('name');
            $table->softDeletes();
        });


        /**
         * Table des utilisteurs
         *
         */
        Schema::create('users', function (Blueprint $table) {
            $table->binaryUuid('uuid');
            $table->stringId('interface_sid', 32, false);
            $table->string('name');
            $table->string('email');
            $table->text('parameters')->nullable();
            $table->string('password', 60);
            $table->string('api_token', 60)->nullable()->unique();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('interface_sid')->references('sid')->on('users_interfaces');
        });


        /**
         * Table des permissions
         *
         *
         */
        Schema::create('users_permissions', function(Blueprint $table) {
            $table->stringId('sid');
            $table->stringId('group_sid', 32, false);
            $table->stringId('interface_sid', 32, false);
            $table->string('name');
            $table->softDeletes();

            $table->foreign('group_sid')->references('sid')->on('users_permissions_groups');
            $table->foreign('interface_sid')->references('sid')->on('users_interfaces');
        });

        /**
         * Table de liaison entre les utilisateurs et les permissions
         *
         *
         */
        Schema::create('users_permissions_users', function(Blueprint $table){
            $table->binaryUuid('user_uuid', false);
            $table->stringId('permission_sid', 32, false);

            $table->foreign('user_uuid')->references('uuid')->on('users');
            $table->foreign('permission_sid')->references('sid')->on('users_permissions');
        });


        /**
         * Table  contenant la navigation pour les interfaces
         *
         */
        Schema::create('users_navigations', function(Blueprint $table){
            $table->stringId('sid', 64);
            $table->stringId('interface_sid', 32, false);
            $table->stringId('permission_sid', 32, false)->nullable();
            $table->stringId('parent_sid', 64, false)->nullable();
            $table->string('name');
            $table->string('link');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('interface_sid')->references('sid')->on('users_interfaces');
            $table->foreign('permission_sid')->references('sid')->on('users_permissions');
        });

        /**
         * Clé étrangère pour la parenté
         *
         */
        Schema::table('users_navigations', function(Blueprint $table) {
            $table->foreign('parent_sid')->references('sid')->on('users_navigations');
        });


        /**
         * Liaison entre un groupe et un utilisateur
         *
         *
         */
        Schema::create('users_groups_users', function(Blueprint $table){
            $table->binaryUuid('user_uuid', false);
            $table->binaryUuid('group_uuid', false);
            $table->primary(['user_uuid', 'group_uuid']);
            $table->foreign('user_uuid')->references('uuid')->on('users');
            $table->foreign('group_uuid')->references('uuid')->on('users_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('users_navigations');
        Schema::dropIfExists('users_interfaces');
        Schema::dropIfExists('users_permission_users');
        Schema::dropIfExists('users_permissions');
    }
}