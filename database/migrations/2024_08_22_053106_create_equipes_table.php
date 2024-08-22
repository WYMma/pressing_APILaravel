<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Equipe', function (Blueprint $table) {
            $table->id('equipeID');
            $table->string('nomEquipe', 50);
            $table->timestamps(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('Equipe');
    }
};
