<?php

use FrenchFrogs\Laravel\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
        Schema::create('user_interface', function(Blueprint $table){
            $table->stringId('user_interface_id');
            $table->string('name');
            $table->softDeletes();
        });

        /**
         * Table de référence des groupe d'utilisateurs
         *
         */
        Schema::create('user_group', function(Blueprint $table){
            $table->binaryUuid('user_group_id');
            $table->string('name');
            $table->softDeletes();
        });

        /**
         * Table de référence des groupes de permissions
         *
         */
        Schema::create('user_permission_group', function (Blueprint $table) {
            $table->stringId('user_permission_group_id');
            $table->string('name');
            $table->softDeletes();
        });


        /**
         * Table des utilisteurs
         *
         */
        Schema::create('user', function (Blueprint $table) {
            $table->binaryUuid('user_id');
            $table->stringId('user_interface_id', 32, false);
            $table->string('name');
            $table->string('email');
            $table->text('parameters')->nullable();
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamp('loggedin_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_interface_id')->references('user_interface_id')->on('user_interface');
        });


        /**
         * Table des permissions
         *
         *
         */
        Schema::create('user_permission', function(Blueprint $table) {
            $table->stringId('user_permission_id', 64);
            $table->stringId('user_permission_group_id', 32, false);
            $table->stringId('user_interface_id', 32, false);
            $table->string('name');
            $table->softDeletes();

            $table->foreign('user_permission_group_id')->references('user_permission_group_id')->on('user_permission_group');
            $table->foreign('user_interface_id')->references('user_interface_id')->on('user_interface');
        });

        /**
         * Table de liaison entre les utilisateurs et les permissions
         *
         *
         */
        Schema::create('user_permission_user', function(Blueprint $table){
            $table->binaryUuid('user_permission_user_id');
            $table->binaryUuid('user_id', false);
            $table->stringId('user_permission_id', 32, false);

            $table->foreign('user_id')->references('user_id')->on('user');
            $table->foreign('user_permission_id')->references('user_permission_id')->on('user_permission');
        });


        /**
         * Table  contenant la navigation pour les interfaces
         *
         */
        Schema::create('user_navigation', function(Blueprint $table){
            $table->stringId('user_navigation_id', 64);
            $table->stringId('user_interface_id', 32, false);
            $table->stringId('user_permission_id', '32', false)->nullable();
            $table->stringId('parent_id', 64, false)->nullable();
            $table->string('name');
            $table->string('link');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_interface_id')->references('user_interface_id')->on('user_interface');
            $table->foreign('user_permission_id')->references('user_permission_id')->on('user_permission');
        });

        /**
         * Clé étrangère pour la parenté
         *
         */
        Schema::table('user_navigation', function(Blueprint $table) {
            $table->foreign('parent_id')->references('user_navigation_id')->on('user_navigation');
        });


        /**
         * Liaison entre un groupe et un utilisateur
         *
         *
         */
        Schema::create('user_group_user', function(Blueprint $table){
            $table->binaryUuid('user_group_user_id');
            $table->binaryUuid('user_id', false);
            $table->binaryUuid('user_group_id', false);

            $table->foreign('user_id')->references('user_id')->on('user');
            $table->foreign('user_group_id')->references('user_group_id')->on('user_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
        Schema::dropIfExists('user_navigation');
        Schema::dropIfExists('user_interface');
        Schema::dropIfExists('user_permission_user');
        Schema::dropIfExists('user_permission');
    }
}

