<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $table = 'Panier';

    protected $primaryKey = 'cartID';

    public $timestamps = true;

    protected $fillable = [
        'total_price',
        'created_at',
    ];

    public function lignePanier()
    {
        return $this->hasMany(LignePanier::class, 'cartID', 'cartID');
    }

    public function commande()
    {
        return $this->hasOne(Commande::class, 'cartID', 'cartID');
    }
}
