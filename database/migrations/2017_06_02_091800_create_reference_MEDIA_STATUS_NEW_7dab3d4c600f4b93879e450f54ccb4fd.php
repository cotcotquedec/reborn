<?php

use App\Models\Db\References;
use Illuminate\Database\Migrations\Migration;


/**
 * Migration pour l'ajout de la reference "MEDIA_STATUS_NEW"
 *
 */
class CreateReferenceMEDIASTATUSNEW7dab3d4c600f4b93879e450f54ccb4fd extends Migration
{
    public function up()
    {
        References::create([
            "rid" => 'MEDIA_STATUS_NEW',
            "name" => 'Nouveau',
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