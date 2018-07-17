<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersRegister extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_register', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id',50);
            $table->string('user_name',50);
            $table->string('user_age',10);
            $table->string('user_height',6);
            $table->string('user_Pre_weight',6);
            $table->string('user_weight',6);
            $table->string('preg_week',3);
            $table->string('date_preg',10);
            $table->string('phone_number');
            $table->string('email');
            $table->string('hospital_name');
            $table->string('hospital_number');
            $table->string('history_medicine');
            $table->string('history_food');
            $table->integer('active_lifestyle');
            $table->integer('status');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('deleted_status');
            //$table->timestamp('updated_at');
            //$table->rememberToken();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_register');
    }
}
