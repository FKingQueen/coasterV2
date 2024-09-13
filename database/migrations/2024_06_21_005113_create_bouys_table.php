<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBouysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bouys', function (Blueprint $table) {
            $table->id();
            $table->integer('bouy_id');
            $table->double('air_temperature', 15, 8);
            $table->double('water_temperature', 15, 8);
            $table->double('barometric_temperature', 15, 8);
            $table->double('ultrasonic', 15, 8);
            $table->double('altitude_pressure', 15, 8);
            $table->double('compass', 15, 8);
            $table->double('significant_wave_height', 15, 8);
            $table->double('wave_period', 15, 8);
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
        Schema::dropIfExists('bouys');
    }
}
