<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoolingDeviceHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('cooling_device_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cooling_device_id');
            $table->foreign('cooling_device_id')->references('id')->on('cooling_devices');
            $table->integer('mode_id');
            $table->foreign('mode_id')->references('id')->on('cooling_device_modes');
            $table->smallInteger('degree')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cooling_device_histories');
    }
}
