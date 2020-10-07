<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectricalMeterHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electrical_meter_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('electrical_meter_id');
            $table->foreign('electrical_meter_id')->references('id')->on('electrical_meters');
            $table->integer('electrical_meter_parameter_id');
            $table->foreign('electrical_meter_parameter_id')->references('id')->on('electrical_meter_parameters');
            $table->string('parameter_value', 50);
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
        Schema::dropIfExists('electrical_meter_histories');
    }
}
