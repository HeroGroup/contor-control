<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoolingDevicesTable extends Migration
{
    public function up()
    {
        Schema::create('cooling_devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('gateway_id');
            $table->foreign('gateway_id')->references('id')->on('gateways');
            $table->string('serial_number', 10);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cooling_devices');
    }
}
