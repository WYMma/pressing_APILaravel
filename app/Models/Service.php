<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $primaryKey = 'serviceID';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];

    public function lignePanier()
    {
        return $this->hasMany(LignePanier::class, 'serviceID', 'serviceID');
    }

    // Accessor to get the full URL of the image
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    // Delete the image file when the service is deleted
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($service) {
            if ($service->image) {
                Storage::delete($service->image);
            }
        });
    }
}
