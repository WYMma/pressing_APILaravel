<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('clientID');
            $table->foreignId('userID')->constrained('users')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('cin')->unique();;
            $table->string('email')->nullable();
            $table->timestamps(); // This will create `created_at` and `updated_at` columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
