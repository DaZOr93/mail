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
            $table->date('date_create');
            $table->date('date_send');
            $table->string('to');
            $table->string('from');
            $table->string('subject');
            $table->text('body');
            $table->boolean('seen');
            $table->date('deleted_ad');
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
