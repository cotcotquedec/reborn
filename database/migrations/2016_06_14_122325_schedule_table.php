<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScheduleTable extends Migration
{
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->string('schedule_id');
            $table->string('command');
            $table->text('description');
            $table->string('schedule');
            $table->boolean('is_active');
            $table->boolean('can_overlapping');
            $table->timestamps();
            $table->primary('schedule_id');
        });
        Schema::create('schedule_log', function (\FrenchFrogs\Laravel\Database\Schema\Blueprint $table) {
            $table->binaryUuid('schedule_log_id');
            $table->string('command');
            $table->text('options')->nullable();
            $table->text('arguments')->nullable();
            $table->text('message')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->integer('duration')->nullable();
            $table->timestamps();
            $table->timestamp('finished_at')->nullable();
        });
    }
}
