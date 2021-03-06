<?php

use FrenchFrogs\Laravel\Database\Schema\Blueprint;
use FrenchFrogs\Laravel\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

/**
 * Ajout du nom placement du fichier par rapport au storage
 *
 * @source Generated by FrenchFrogs\App\Console\CodeMigrationCommand
 * @since Jun 3, 2017
 * @author cotcotquedec@gmail.com
 */
class MediasAddStorageFile6o4F2x extends Migration
{
    public function up()
    {
        Schema::table("medias", function (Blueprint $table) {
            $table->string('storage_path')->after('realpath');
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
