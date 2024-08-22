<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id('itemID');
            $table->unsignedBigInteger('categorieID');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->binary('photo');

            $table->foreign('categorieID')->references('id')->on('Categories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
};
