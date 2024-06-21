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
            $table->double('wave_height', 15, 8);
            $table->double('tide_height', 15, 8);
            $table->double('wave_period', 15, 8);
            $table->double('wave_power', 15, 8);
            $table->double('wave_temperature', 15, 8);
            $table->double('air_temperature', 15, 8);
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
