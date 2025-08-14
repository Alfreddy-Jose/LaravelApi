<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloquesTurno extends Model
{
    public $fillable = [
        'turno_id',
        'rango',
        'periodo',
        'tipo_turno'
    ];

    public function turno(){
        return $this->belongsTo(Turno::class);
    }
}
