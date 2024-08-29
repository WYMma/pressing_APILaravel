<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ApiKey extends Model
{
    protected $fillable = ['name', 'api_key'];

    // Encrypt the API key before saving it to the database
    public function setApiKeyAttribute($value)
    {
        $this->attributes['api_key'] = Crypt::encryptString($value);
    }

    // Decrypt the API key when retrieving it from the database
    public function getApiKeyAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}

