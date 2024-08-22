<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id('commandeID');
            $table->unsignedBigInteger('clientID');
            $table->unsignedInteger('addressID');
            $table->dateTime('pickUpDate');
            $table->dateTime('deliveryDate');
            $table->string('paymentMethod');
            $table->string('deliveryType');
            $table->timestamp('confirmationTimestamp')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('status')->nullable();
            $table->unsignedBigInteger('cartID')->nullable();
            $table->decimal('totalPrice', 10, 2);
            $table->unsignedBigInteger('transporterID')->nullable();
            $table->boolean('isConfirmed')->default(false);
            $table->boolean('isPickedUp')->default(false);
            $table->boolean('isInProgress')->default(false);
            $table->boolean('isShipped')->default(false);
            $table->boolean('isDelivered')->default(false);
            $table->timestamps();

            $table->foreign('clientID')->references('clientID')->on('clients');
            $table->foreign('addressID')->references('addressID')->on('Addresses');
            $table->foreign('cartID')->references('cartID')->on('paniers');
            $table->foreign('transporterID')->references('personnelID')->on('personnels');
        });
    }

    public function down()
    {
        Schema::dropIfExists('commandes');
    }
};
