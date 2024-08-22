<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $table = 'Mission';

    protected $primaryKey = 'missionID';

    public $timestamps = true;

    protected $fillable = [
        'description',
        'equipeID',
        'date_mission',
        'commandeID',
        'created_at',
    ];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'equipeID', 'equipeID');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commandeID', 'commandeID');
    }
}
