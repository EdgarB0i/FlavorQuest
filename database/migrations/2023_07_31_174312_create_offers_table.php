<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->string('description');
            $table->integer('discount_percentage');
            // Add any other columns you need for the offers table
            $table->timestamps();

            // Define the foreign key relationship
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
