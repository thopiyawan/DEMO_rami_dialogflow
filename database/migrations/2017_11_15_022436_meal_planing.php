<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MealPlaning extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('meal_planing', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('caloric_level');
            $table->integer('starches');
            $table->integer('vegetables');
            $table->integer('fruits');
            $table->integer('meats');
            $table->integer('fats');
            $table->integer('lf_milk');
            $table->integer('c');
            $table->integer('p');
            $table->integer('f');
            $table->integer('g_protein');
            //$table->timestamp('created_at');
            //$table->timestamp('updated_at');
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
        Schema::dropIfExists('meal_planing');
    }
}
