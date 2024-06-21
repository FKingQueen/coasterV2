<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaterLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('water_levels', function (Blueprint $table) {
            $table->id();
            $table->integer('wlms_id');
            $table->decimal('level', 8, 2);
            $table->decimal('temperature', 8, 2);
            $table->decimal('humidity', 8, 2);
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
        Schema::dropIfExists('water_levels');
    }
}
