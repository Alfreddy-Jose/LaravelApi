<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pnf extends Model
{
    //
    protected $fillable = [
        'id',
        'codigo',
        'nombre',
        'abreviado',
        'abreviado_coord'
    ];
    // Relación con el modelo Tipo_persona
    public function tipo_persona()
    {
        return $this->hasMany(Tipo_persona::class, 'pnf_id');
    }
    // Relación con el modelo Seccion
    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'pnf_id');
    }

    // Relacion con el modelo de sedes
    public function sedes()
    {
        return $this->belongsToMany(Sede::class);
    }
}
