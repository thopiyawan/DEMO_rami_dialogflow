<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sequents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('seqcode');
            $table->string('question');
            $table->string('answer');
            $table->integer('nexttype');
            $table->string('nextseqcode');
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
         Schema::dropIfExists('sequents');
    }
}

