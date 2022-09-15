<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousingModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('housing_models', function (Blueprint $table) {
            $table->id();
            $table->string('heading')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('bedrooms')->nullable();
            $table->string('bathrooms')->nullable();
            $table->string('width')->nullable();
            $table->string('garages')->nullable();
            $table->string('patios')->nullable();
            $table->boolean('include_in_application')->default(false);
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
        Schema::dropIfExists('housing_models');
    }
}
