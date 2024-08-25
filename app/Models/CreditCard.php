<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    // The table associated with the model (optional, only if you want to specify it)
    protected $table = 'credit_cards';
    protected $primaryKey = 'cardID';
    public $incrementing = true;
    public $timestamps = true;

    // The attributes that are mass assignable
    protected $fillable = [
        'number',
        'holder',
        'expiry',
        'cvv',
        'clientID',
    ];

    // Define the relationship with the Client model
    public function client()
    {
        return $this->belongsTo(Client::class, 'clientID');
    }
}

