<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->float('ambience')->default(0);
            $table->float('service')->default(0);
            $table->float('pricing')->default(0);
            $table->integer('ambience_count')->default(0);
            $table->integer('service_count')->default(0);
            $table->integer('pricing_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant_ratings');
    }
}
