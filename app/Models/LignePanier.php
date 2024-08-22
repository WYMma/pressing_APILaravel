<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LignePanier extends Model
{
    use HasFactory;

    protected $table = 'Ligne_Panier';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'quantity',
        'serviceID',
        'cartID',
        'itemID',
    ];

    public function service()
    {
        return $this->belongsTo(Services::class, 'serviceID', 'id');
    }

    public function panier()
    {
        return $this->belongsTo(Panier::class, 'cartID', 'cartID');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemID', 'itemID');
    }
}
