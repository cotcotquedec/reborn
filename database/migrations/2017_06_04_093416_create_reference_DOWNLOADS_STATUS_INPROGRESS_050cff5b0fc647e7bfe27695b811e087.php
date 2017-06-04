<?php

use App\Models\Db\References;
use Illuminate\Database\Migrations\Migration;


/**
 * Migration pour l'ajout de la reference "DOWNLOADS_STATUS_INPROGRESS"
 *
 */
class CreateReferenceDOWNLOADSSTATUSINPROGRESS050cff5b0fc647e7bfe27695b811e087 extends Migration
{
    public function up()
    {
        References::create([
            "rid" => 'DOWNLOADS_STATUS_INPROGRESS',
            "name" => 'En cours',
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