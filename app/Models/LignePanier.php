<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LignePanier extends Model
{
    use HasFactory;

    protected $table = 'lignepaniers';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'quantity',
        'serviceID',
        'cartID',
        'itemID',
        'initialPrice',
        'productPrice',
        'categorieID',
    ];

    public function category()
    {
        return $this->belongsTo(Categorie::class, 'categorieID', 'categorieID');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'serviceID', 'serviceID');
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
