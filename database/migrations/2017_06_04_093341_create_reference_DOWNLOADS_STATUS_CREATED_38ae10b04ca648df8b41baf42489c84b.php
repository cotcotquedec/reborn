<?php

use App\Models\Db\References;
use Illuminate\Database\Migrations\Migration;


/**
 * Migration pour l'ajout de la reference "DOWNLOADS_STATUS_CREATED"
 *
 */
class CreateReferenceDOWNLOADSSTATUSCREATED38ae10b04ca648df8b41baf42489c84b extends Migration
{
    public function up()
    {
        References::create([
            "rid" => 'DOWNLOADS_STATUS_CREATED',
            "name" => 'CRréé',
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