<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lignePaniers', function (Blueprint $table) {
            $table->id('id');
            $table->integer('quantity');
            $table->unsignedBigInteger('serviceID');
            $table->unsignedBigInteger('cartID');
            $table->unsignedBigInteger('itemID');

            $table->foreign('serviceID')->references('id')->on('Services');
            $table->foreign('cartID')->references('cartID')->on('paniers');
            $table->foreign('itemID')->references('itemID')->on('items');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lignePaniers');
    }
};
