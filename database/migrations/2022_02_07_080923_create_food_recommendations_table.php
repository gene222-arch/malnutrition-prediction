<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->string('image_url');
            $table->text('description')->nullable();
            $table->unsignedInteger('min_age_recommended');
            $table->unsignedInteger('max_age_recommended');
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
        Schema::dropIfExists('food_recommendations');
    }
}
