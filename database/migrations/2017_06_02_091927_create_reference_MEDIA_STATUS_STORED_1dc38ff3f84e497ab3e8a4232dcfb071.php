<?php

use App\Models\Db\References;
use Illuminate\Database\Migrations\Migration;


/**
 * Migration pour l'ajout de la reference "MEDIA_STATUS_STORED"
 *
 */
class CreateReferenceMEDIASTATUSSTORED1dc38ff3f84e497ab3e8a4232dcfb071 extends Migration
{
    public function up()
    {
        References::create([
            "rid" => 'MEDIA_STATUS_STORED',
            "name" => 'Trié',
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