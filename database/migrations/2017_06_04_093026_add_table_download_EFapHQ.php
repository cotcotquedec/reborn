<?php

use FrenchFrogs\Laravel\Database\Schema\Blueprint;
use FrenchFrogs\Laravel\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

/**
 * downloads
 *
 * @source Generated by FrenchFrogs\App\Console\CodeMigrationCommand
 * @since Jun 4, 2017
 * @author cotcotquedec@gmail.com
 */
class AddTableDownloadEFapHQ extends Migration
{
    public function up()
    {
        Schema::create("downloads", function (Blueprint $table) {
            $table->binaryUuid();
            $table->reference('status_rid');
            $table->string('url');
            $table->text('errors')->nullable();
            $table->dateTime('completed_at')->nullable();
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
        //
    }
}