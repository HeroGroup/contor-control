<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectricalMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electrical_meters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serial_number', 10);
            $table->bigInteger('gateway_id');
            $table->foreign('gateway_id')->references('id')->on('gateways');
            $table->integer('electrical_meter_type_id')->nullable();
            $table->foreign('electrical_meter_type_id')->references('id')->on('electrical_meter_types');
            $table->smallInteger('phase')->nullable();
            $table->tinyInteger('relay1_status')->nullable();
            $table->tinyInteger('relay2_status')->nullable();
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
        Schema::dropIfExists('electrical_meters');
    }
}
