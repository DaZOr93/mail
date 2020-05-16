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
            $table->timestamp('date_send')->nullable();
            $table->string('to');
            $table->string('from');
            $table->string('to_name');
            $table->string('from_name');
            $table->string('subject');
            $table->text('html');
            $table->boolean('sending')->default(0);
            $table->boolean('inbox')->default(1);
            $table->boolean('seen')->default(1);
            $table->boolean('favorite')->default(0);
            $table->boolean('deleted')->default(0);
            $table->boolean('draft')->default(0);
            $table->boolean('attach');
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
