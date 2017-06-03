<?php

use FrenchFrogs\Laravel\Database\Schema\Blueprint;
use FrenchFrogs\Laravel\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

/**
 *
 *
 * @source Generated by FrenchFrogs\App\Console\CodeMigrationCommand
 * @since Jun 3, 2017
 * @author cotcotquedec@gmail.com
 */
class AddStredAtMediaPJLd1y extends Migration
{
    public function up()
    {
        Schema::table("medias", function (Blueprint $table) {
            $table->dateTime('stored_at')->nullable()->before('created_at');
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
