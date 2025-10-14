<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocero extends Model
{
    public $fillable = [
        "seccion_id",
        "persona_id"
    ];

    // Relación con el modelo Persona
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    // Relación con el modelo Sección
    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }
}
