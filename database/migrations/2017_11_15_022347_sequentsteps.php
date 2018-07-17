<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sequentsteps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequentsteps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sender_id');
            $table->string('seqcode');
            $table->string('answer');
            $table->string('nextseqcode');
            $table->string('status');
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
        Schema::dropIfExists('sequentsteps');
    }
}
