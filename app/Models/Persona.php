<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'cedula_persona',
        'nombre',
        'apellido',
        'direccion',
        'municipio',
        'telefono',
        'email',
        'tipo_persona',
        'grado_inst'
    ];
}
