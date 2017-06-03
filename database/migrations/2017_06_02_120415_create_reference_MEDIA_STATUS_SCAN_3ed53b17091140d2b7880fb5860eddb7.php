<?php

use App\Models\Db\References;
use Illuminate\Database\Migrations\Migration;


/**
 * Migration pour l'ajout de la reference "MEDIA_STATUS_SCAN"
 *
 */
class CreateReferenceMEDIASTATUSSCAN3ed53b17091140d2b7880fb5860eddb7 extends Migration
{
    public function up()
    {
        References::create([
            "rid" => 'MEDIA_STATUS_SCAN',
            "name" => 'Scanné',
            "collection" => 'media.status'
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