<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    protected $fillable = [
        "etapa",
        "nombre_lab",
        "abreviado_lab",
        "equipos"
    ];
}
