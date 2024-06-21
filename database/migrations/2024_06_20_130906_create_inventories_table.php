<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('image')->nullable();
            $table->string("coastalID");
            $table->string("province");
            $table->string("coastalProtection");
            $table->double('latitude', 15, 8);
            $table->double('longitude', 15, 8);
            $table->string("locationType");
            $table->string("yearCompleted");
            $table->string("length");
            $table->string("heightRange");
            $table->string("primaryMaterial");
            $table->string("conditionRating");
            $table->string("crDesc");
            $table->string("priorityRating");
            $table->string("prDesc");
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
        Schema::dropIfExists('inventories');
    }
}
