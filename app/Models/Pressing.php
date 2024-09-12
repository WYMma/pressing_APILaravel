<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pressing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'written_address', 'google_map_address', 'phone_number', 'image','description'];

    public function getImageAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }
}
