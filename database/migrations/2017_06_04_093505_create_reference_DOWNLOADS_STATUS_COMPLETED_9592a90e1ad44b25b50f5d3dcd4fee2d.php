<?php

use App\Models\Db\References;
use Illuminate\Database\Migrations\Migration;


/**
 * Migration pour l'ajout de la reference "DOWNLOADS_STATUS_COMPLETED"
 *
 */
class CreateReferenceDOWNLOADSSTATUSCOMPLETED9592a90e1ad44b25b50f5d3dcd4fee2d extends Migration
{
    public function up()
    {
        References::create([
            "rid" => 'DOWNLOADS_STATUS_COMPLETED',
            "name" => 'Complet',
            "collection" => 'downloads.status'
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