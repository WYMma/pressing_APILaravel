<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id('saleID');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('discount', 5, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('image')->nullable();
            $table->foreignId('serviceID')->references('serviceID')->on('services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
