<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LapsoAcademico extends Model
{
    protected $fillable = [
        'nombre_lapso',
        'ano',
        'tipo_lapso_id'
    ];
    // Relación con el modelo Tipo_persona
    public function tipo_persona()
    {
        return $this->hasMany(Tipo_persona::class, 'lapso_academico_id');
    }

    public function tipoLapso()
    {
        return $this->belongsTo(TipoLapso::class);
    }
    // Relación con el modelo Seccion
    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'lapso_id');
    }
}
