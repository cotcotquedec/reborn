<?php

use App\Models\Db\References;
use Illuminate\Database\Migrations\Migration;


/**
 * Migration pour l'ajout de la reference "MEDIA_TYPE_TVSHOW"
 *
 */
class CreateReferenceMEDIATYPETVSHOW5f5a387254aa494da1b6654626e6f98b extends Migration
{
    public function up()
    {
        References::create([
            "rid" => 'MEDIA_TYPE_TVSHOW',
            "name" => 'Series',
            "collection" => 'media.type'
        ]);
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