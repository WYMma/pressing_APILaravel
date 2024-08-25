<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->id('personnelID');
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('equipeID')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('cin')->unique();
            $table->string('email')->nullable();
            $table->timestamp('joined_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('equipeID')->references('equipeID')->on('Equipe')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('personnels');
    }
};
