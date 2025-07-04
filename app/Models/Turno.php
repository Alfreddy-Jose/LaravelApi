<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    public $fillable = [
        'nombre',
        'inicio',
        'final'
    ];

    public function bloques()
    {
        return $this->hasMany(Bloques::class);
    }
}
