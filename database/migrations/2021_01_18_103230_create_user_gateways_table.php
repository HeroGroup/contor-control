<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gateways', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('gateway_id');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gateway_id')->references('id')->on('gateways')->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
            $table->primary(['user_id','gateway_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_gateways');
    }
}
