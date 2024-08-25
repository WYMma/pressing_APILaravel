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
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id('cardID');
            $table->string('number');
            $table->string('holder');
            $table->string('expiry');
            $table->string('cvv');
            $table->unsignedBigInteger('clientID');
            $table->timestamps();

            // Foreign key constraint
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
        Schema::dropIfExists('credit_cards');
    }
};
