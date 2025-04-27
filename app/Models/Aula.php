<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    protected $fillable = [
        "codigo",
        "etapa",
        "nro_aula",
        "nombre_aula"
    ];
}
