<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id('missionID');
            $table->text('description');
            $table->unsignedBigInteger('equipeID')->nullable();
            $table->date('date_mission');
            $table->unsignedBigInteger('commandeID');
            $table->string('status');
            $table->timestamps();

            $table->foreign('equipeID')->references('equipeID')->on('Equipe');
            $table->foreign('commandeID')->references('commandeID')->on('Commandes');
        });
    }

    public function down()
    {
        Schema::dropIfExists('missions');
    }
};
