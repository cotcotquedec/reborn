<?php

use FrenchFrogs\Laravel\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_type', function (Blueprint $table) {
            $table->stringId('media_type_id');
            $table->string('name');
        });
        Schema::create('media', function (Blueprint $table) {
            $table->binaryUuid('media_id');
            $table->string('media_type_id');
            $table->string('hash_md5');
            $table->timestamps();
            $table->foreign('media_type_id')->references('media_type_id')->on('media_type')->onDelete('cascade');
        });
        Schema::create('media_attachment', function (Blueprint $table) {
            $table->binaryUuid('media_id');
            $table->string('name');
            $table->binary('content');
            $table->integer('size')->default(0);
            $table->string('mime')->nullable();
            $table->timestamps();
        });
        
        \FrenchFrogs\Models\Db\Media\Type::create(['media_type_id' => \Models\Business\Media::TYPE_USER_AVATAR, 'name' => 'Avatar']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('media')) {
            Schema::table('media', function (Blueprint $table) {
                $table->dropForeign('media_type_id');
            });
        }
        Schema::dropIfExists('media_attachment');
        Schema::dropIfExists('media');
        Schema::dropIfExists('media_type');
    }
}
