<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'Item';

    protected $primaryKey = 'itemID';

    public $timestamps = false;

    protected $fillable = [
        'categorieID',
        'name',
        'price',
        'photo',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'categorieID', 'id');
    }

    public function lignePanier()
    {
        return $this->hasMany(LignePanier::class, 'itemID', 'itemID');
    }
}
