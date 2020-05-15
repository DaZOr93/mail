<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('folder_id')->nullable();
            $table->string('message_id');
            $table->string('uid');
            $table->string('date_send');
            $table->string('to');
            $table->string('from');
            $table->string('subject');
            $table->text('body');
            $table->boolean('seen');
            $table->boolean('favorite');
            $table->date('deleted_ad')->nullable();
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
        Schema::dropIfExists('letters');
    }
}
