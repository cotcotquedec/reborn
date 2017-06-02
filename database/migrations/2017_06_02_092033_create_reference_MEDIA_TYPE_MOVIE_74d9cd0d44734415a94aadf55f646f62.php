<?php

use App\Models\Db\References;
use Illuminate\Database\Migrations\Migration;


/**
 * Migration pour l'ajout de la reference "MEDIA_TYPE_MOVIE"
 *
 */
class CreateReferenceMEDIATYPEMOVIE74d9cd0d44734415a94aadf55f646f62 extends Migration
{
    public function up()
    {
        References::create([
            "rid" => 'MEDIA_TYPE_MOVIE',
            "name" => 'Films',
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