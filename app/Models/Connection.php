<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    protected $table = 'Connection';

    protected $primaryKey = 'connectionID';

    public $timestamps = false;

    protected $fillable = [
        'userID',
        'tokenFCM',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
}
