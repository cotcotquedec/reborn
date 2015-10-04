<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Media extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('media_attachment');
        Schema::dropIfExists('media');
        Schema::dropIfExists('media_type');
        Schema::create('media_type', function (Blueprint $table) {
            $table->string('media_type_id', 32);
            $table->string('name');
            $table->primary('media_type_id');
        });

        Schema::create('media', function (Blueprint $table) {
            $table->increments('media_id');
            $table->string('media_type_id', 32);
            $table->string('hash_md5');
            $table->timestamps();
            $table->foreign('media_type_id')->references('media_type_id')->on('media_type')->onDelete('cascade');
        });

        Schema::create('media_attachment', function(Blueprint $table){
            $table->integer('media_id');
            $table->string('name');
            $table->binary('content');
            $table->integer('size')->default(0);
            $table->string('mime')->nullable();
            $table->timestamps();
            $table->primary('media_id');
        });


        \Models\Db\Media\Type::create(['media_type_id' => \Models\Business\Media::TYPE_USER_AVATAR, 'name' => 'Avatar']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('media_attachment');
        Schema::drop('media');
        Schema::drop('media_type');
    }
}
