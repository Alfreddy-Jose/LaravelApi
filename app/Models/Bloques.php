<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloques extends Model
{
    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }
}
