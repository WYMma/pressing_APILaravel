<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $primaryKey = 'itemID';

    public $timestamps = true;

    protected $fillable = [
        'categorieID',
        'name',
        'price',
        'photo',
    ];

    public function category()
    {
        return $this->belongsTo(Categorie::class, 'categorieID', 'categorieID');
    }

    public function lignePanier()
    {
        return $this->hasMany(LignePanier::class, 'itemID', 'itemID');
    }

    // Accessor for the photo URL
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? Storage::url($this->photo) : null;
    }
}
