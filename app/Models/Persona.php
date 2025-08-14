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
    // Relación con el modelo Tipo_persona
/*     public function tipo_persona()
    {
        return $this->hasMany(Tipo_persona::class, 'persona_id');
    } */

    // Relacion con el modelo Docente
    public function docente()
    {
        return $this->hasOne(Docente::class);
    }
}
