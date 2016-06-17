<?php

use FrenchFrogs\Laravel\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPermissionRoleNavigation extends Migration
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
         *
         *
         */
        Schema::create('user_interface', function(Blueprint $table){
            $table->string('user_interface_id', 16)->primary();
            $table->string('name');
        });

        /**
         *
         *
         */
        Schema::create('user', function (Blueprint $table) {
            $table->binaryUuid('user_id')->primary();
            $table->string('user_interface_id', 16);
            $table->string('name');
            $table->string('email');
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamp('loggedin_at')->nullable();
            $table->timestamp('failedlogin_at')->nullable();
            $table->timestamps();

            $table->foreign('user_interface_id')->references('user_interface_id')->on('user_interface');
        });


        /**
         *
         *
         */
        Schema::create('user_permission_group', function (Blueprint $table) {
            $table->string('user_permission_group_id', 32)->primary();
            $table->string('name');
        });

        /**
         *
         *
         *
         */
        Schema::create('user_permission', function(Blueprint $table) {
            $table->string('user_permission_id', 64)->primary();
            $table->string('user_permission_group_id', 32);
            $table->string('user_interface_id', 16);

            $table->string('name');


            $table->foreign('user_permission_group_id')->references('user_permission_group_id')->on('user_permission_group');
            $table->foreign('user_interface_id')->references('user_interface_id')->on('user_interface');
        });

        /**
         *
         *
         *
         */
        Schema::create('user_permission_user', function(Blueprint $table){
            $table->binaryUuid('user_permission_user_id')->primary();
            $table->binaryUuid('user_id');
            $table->string('user_permission_id');

            $table->foreign('user_id')->references('user_id')->on('user');
            $table->foreign('user_permission_id')->references('user_permission_id')->on('user_permission');
        });




        /**
         *
         *
         */
        Schema::create('user_navigation', function(Blueprint $table){
            $table->string('user_navigation_id', 64)->primary();
            $table->string('user_interface_id', 16);
            $table->string('user_permission_id')->nullable();
            $table->string('parent_id', 64)->nullable();
            $table->string('name');
            $table->string('link');
            $table->timestamps();

            $table->foreign('user_interface_id')->references('user_interface_id')->on('user_interface');
            $table->foreign('user_permission_id')->references('user_permission_id')->on('user_permission');
        });

        Schema::table('user_navigation', function(Blueprint $table){
            $table->foreign('parent_id')->references('user_navigation_id')->on('user_navigation');
        });

        /**
         *
         *
         */
        Schema::create('user_group', function(Blueprint $table){
            $table->binaryUuid('user_group_id')->primary();
            $table->string('name', 255);
        });


        /**
         *
         */
        Schema::create('user_group_user', function(Blueprint $table){
            $table->binaryUuid('user_group_user_id')->primary();
            $table->binaryUuid('user_id');
            $table->binaryUuid('user_group_id');

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

