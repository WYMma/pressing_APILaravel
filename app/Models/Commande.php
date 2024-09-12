<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'Commandes';

    protected $primaryKey = 'commandeID';

    public $timestamps = true;

    protected $fillable = [
        'clientID',
        'addressID',
        'pickUpDate',
        'deliveryDate',
        'paymentMethod',
        'deliveryType',
        'confirmationTimestamp',
        'status',
        'cartID',
        'totalPrice',
        'isConfirmed',
        'isPickedUp',
        'isInProgress',
        'isShipped',
        'isDelivered',
        'created_at',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'clientID', 'clientID');
    }

    public function address()
    {
        return $this->belongsTo(Addresse::class, 'addressID', 'addressID');
    }

    public function panier()
    {
        return $this->belongsTo(Panier::class, 'cartID', 'cartID');
    }

    public function mission()
    {
        return $this->hasMany(Mission::class, 'commandeID', 'commandeID');
    }
}
