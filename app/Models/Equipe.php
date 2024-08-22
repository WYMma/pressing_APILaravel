<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;

    protected $table = 'Equipe';

    protected $primaryKey = 'equipeID';

    public $timestamps = true;

    protected $fillable = [
        'nomEquipe',
        'created_at',
    ];

    public function personnel()
    {
        return $this->hasMany(Personnel::class, 'equipeID', 'equipeID');
    }

    public function missions()
    {
        return $this->hasMany(Mission::class, 'equipeID', 'equipeID');
    }
}
