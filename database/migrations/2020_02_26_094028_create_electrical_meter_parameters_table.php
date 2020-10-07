<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectricalMeterParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electrical_meter_parameters', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('electrical_meter_type_id')->nullable();
            $table->foreign('electrical_meter_type_id')->references('id')->on('electrical_meter_types');
            $table->string('parameter_code', 50)->nullable();
            $table->string('parameter_title', 50)->nullable();
            $table->string('parameter_unit', 50)->nullable();
            $table->string('parameter_type', 50)->nullable(); // serial,tariff,voltage,current,date,time,unimportant
            $table->smallInteger('parameter_type_index')->nullable();
            $table->unsignedTinyInteger('priority')->nullable();
            $table->string('parameter_label', 50)->nullable();
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
        Schema::dropIfExists('electrical_meter_parameters');
    }
}
