<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModifyContorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modify_contors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('gateway_id');
            $table->foreign('gateway_id')->references('id')->on('gateways');
            $table->bigInteger('electrical_meter_id');
            $table->foreign('electrical_meter_id')->references('id')->on('electrical_meters');
            $table->boolean('relay1_status')->nullable();
            $table->boolean('relay2_status')->nullable();
            $table->boolean('checked')->default(false);
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
        Schema::dropIfExists('modify_contors');
    }
}
