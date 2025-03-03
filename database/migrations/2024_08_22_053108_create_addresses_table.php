<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Addresses', function (Blueprint $table) {
            $table->id('addressID'); // Primary key
            $table->bigInteger('clientID')->unsigned();
            $table->string('area', 50);
            $table->string('street', 255);
            $table->string('city', 255);
            $table->string('postal_code', 10);
            $table->string('type')->nullable();
            $table->timestamps();

            $table->foreign('clientID')->references('clientID')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Addresses');
    }
};
