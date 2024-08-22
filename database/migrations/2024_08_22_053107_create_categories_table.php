<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Categories', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->binary('photo');
            $table->text('description');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Categories');
    }
};
