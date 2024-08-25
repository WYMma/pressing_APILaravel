<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresse extends Model
{
    use HasFactory;

    protected $table = 'Addresses';

    // The primary key is now a single key: addressID
    protected $primaryKey = 'addressID';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'clientID',
        'area',
        'street',
        'city',
        'postal_code',
        'type',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'clientID', 'clientID');
    }

    public function commande()
    {
        return $this->hasMany(Commande::class, 'addressID', 'addressID');
    }
}
