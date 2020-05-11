<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->string('email');
            $table->string('password');
            $table->string('driver');
            $table->integer('port');
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
        Schema::dropIfExists('pickers');
    }
}
