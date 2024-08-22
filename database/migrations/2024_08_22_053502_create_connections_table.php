<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Connection', function (Blueprint $table) {
            $table->id('connectionID');
            $table->unsignedBigInteger('userID');
            $table->text('tokenFCM');
            $table->timestamps();

            $table->foreign('userID')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Connection');
    }
};
