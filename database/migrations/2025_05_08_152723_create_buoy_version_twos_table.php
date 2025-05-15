<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuoyVersionTwosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buoy_version_twos', function (Blueprint $table) {
            $table->id();
            $table->integer('buoy_id');
            $table->double('SWH', 15, 8);
            $table->double('AWP', 15, 8);
            $table->double('Temp', 15, 8);
            $table->double('Year', 15, 8);
            $table->double('Month', 15, 8);
            $table->double('Day', 15, 8);
            $table->double('Hour', 15, 8);
            $table->double('Min', 15, 8);
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
        Schema::dropIfExists('buoy_version_twos');
    }
}
