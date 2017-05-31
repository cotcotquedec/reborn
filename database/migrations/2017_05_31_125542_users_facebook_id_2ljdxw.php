<?php 

use Illuminate\Database\Migrations\Migration;
use FrenchFrogs\Laravel\Database\Schema\Blueprint;
use FrenchFrogs\Laravel\Support\Facades\Schema;

/**
 *
 *
 * @source Generated by FrenchFrogs\App\Console\CodeMigrationCommand
 * @since May 31, 2017
 * @author cotcotquedec@gmail.com
 */
class UsersFacebookId2ljdxw extends Migration
{
    public function up()
    {
        Schema::table("users", function (Blueprint $table) {
          $table->string('facebook_id', 32)->after('name')->nullable();
        });
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
