<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->string('dish_name');
            $table->float('price');
            $table->integer('rating');
            
            $table->timestamps();

            // Define the foreign key relationship
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
