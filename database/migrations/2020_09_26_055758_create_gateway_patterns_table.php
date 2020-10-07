<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatewayPatternsTable extends Migration
{
    public function up()
    {
        Schema::create('gateway_patterns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('gateway_id');
            $table->foreign('gateway_id')->references('id')->on('gateways');
            $table->integer('pattern_id');
            $table->foreign('pattern_id')->references('id')->on('patterns');
            $table->tinyInteger('happened')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gateway_patterns');
    }
}
