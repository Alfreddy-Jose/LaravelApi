<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = ['seccion_id', 'trimestre_id', 'nombre', 'estado', 'lapso_academico'];

    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }
    public function trimestre()
    {
        return $this->belongsTo(Trimestre::class);
    }
    public function Clase()
    {
        return $this->hasMany(Clase::class);
    }
}
