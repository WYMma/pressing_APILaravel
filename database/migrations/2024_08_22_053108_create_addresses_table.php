<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->unsignedInteger('addressID');
            $table->unsignedBigInteger('clientID');
            $table->string('area', 50);
            $table->string('street');
            $table->string('city');
            $table->string('postal_code', 10);
            $table->string('type')->nullable();

            $table->primary(['addressID', 'clientID']);
            $table->foreign('clientID')->references('clientID')->on('clients');
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
