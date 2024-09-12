<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $primaryKey = 'saleID';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'discount',
        'start_date',
        'end_date',
        'image',
        'serviceID',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'serviceID');
    }

    // Accessor to get the full URL of the image
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    // Delete the image file when the sale is deleted
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($sale) {
            if ($sale->image) {
                Storage::delete($sale->image);
            }
        });
    }
}

