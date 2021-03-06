<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('Ma GV');
            $table->integer('class_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->integer('room_id')->unsigned()->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_change')->nullable();
            $table->boolean('session')->nullable();
            $table->tinyInteger('semester');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('room_id')->references('id')->on('rooms');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
