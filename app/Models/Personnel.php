<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    protected $table = 'Personnel';

    protected $primaryKey = 'personnelID';

    public $timestamps = true;

    protected $fillable = [
        'userID',
        'equipeID',
        'first_name',
        'last_name',
        'cin',
        'email',
        'joined_at',
    ];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'equipeID', 'equipeID');
    }

    public function commande()
    {
        return $this->hasMany(Commande::class, 'transporterID', 'personnelID');
    }
}
