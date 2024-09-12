<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'clientID'; // Specify primary key
    public $incrementing = true; // Indicates if the ID is auto-incrementing
    protected $fillable = [
        'userID',
        'first_name',
        'last_name',
        'cin',
        'email',
        'joined_at',
    ];

    protected $table = 'clients';

    public $timestamps = true;
}
