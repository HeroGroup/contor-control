<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatternsTable extends Migration
{
    public function up()
    {
        Schema::create('patterns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('start_time', 10)->nullable();
            $table->string('end_time', 10)->nullable();
            $table->integer('mode_id')->nullable();
            $table->foreign('mode_id')->references('id')->on('cooling_device_modes');
            $table->smallInteger('degree')->nullable();
            $table->smallInteger('max_current')->nullable();
            $table->smallInteger('minutes_after')->nullable();
            $table->tinyInteger('relay_status')->nullable();
            $table->smallInteger('off_minutes')->nullable();
            $table->tinyInteger('pattern_type');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('patterns');
    }
}
