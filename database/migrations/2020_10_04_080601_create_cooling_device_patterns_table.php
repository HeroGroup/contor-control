<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoolingDevicePatternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooling_device_patterns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cooling_device_id');
            $table->foreign('cooling_device_id')->references('id')->on('cooling_devices');
            $table->integer('pattern_id');
            $table->foreign('pattern_id')->references('id')->on('patterns');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cooling_device_patterns');
    }
}
