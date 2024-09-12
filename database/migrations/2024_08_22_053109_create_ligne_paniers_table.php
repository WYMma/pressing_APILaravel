<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lignePaniers', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->unsignedBigInteger('serviceID');
            $table->unsignedBigInteger('cartID');
            $table->unsignedBigInteger('itemID');
            $table->unsignedBigInteger('categorieID');
            $table->double('initialPrice');
            $table->double('productPrice');

            $table->foreign('serviceID')->references('serviceID')->on('Services');
            $table->foreign('cartID')->references('cartID')->on('paniers')->onDelete('cascade');;
            $table->foreign('itemID')->references('itemID')->on('items');
            $table->foreign('categorieID')->references('categorieID')->on('categories');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lignePaniers');
    }
};
