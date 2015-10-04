<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('name');
            $table->integer('media_id')->nullable();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->boolean('is_active');
            $table->boolean('is_contributor');
            $table->boolean('is_admin');
            $table->rememberToken();
            $table->timestamp('loggedin_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
