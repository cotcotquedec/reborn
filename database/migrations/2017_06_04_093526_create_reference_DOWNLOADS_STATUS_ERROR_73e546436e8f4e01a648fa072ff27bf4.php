<?php

use App\Models\Db\References;
use Illuminate\Database\Migrations\Migration;


/**
 * Migration pour l'ajout de la reference "DOWNLOADS_STATUS_ERROR"
 *
 */
class CreateReferenceDOWNLOADSSTATUSERROR73e546436e8f4e01a648fa072ff27bf4 extends Migration
{
    public function up()
    {
        References::create([
            "rid" => 'DOWNLOADS_STATUS_ERROR',
            "name" => 'Error',
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