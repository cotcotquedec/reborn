<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        Schema::table('user', function(Blueprint $table)
        {
            $table->string('nickname')->unique()->change();
            $table->string('password', 60)->after('nickname');
            $table->rememberToken();
            $table->timestamps();
            $table->dropColumn('subscription_end');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Schema::drop('users');
	}

}
