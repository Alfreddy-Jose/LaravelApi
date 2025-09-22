<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $fillable = [
        'nro_sede',
        'nombre_sede',
        'nombre_abreviado',
        'direccion',
        'municipio_id',
        'universidad_id'
    ];

    public function espacios()
    {
        return $this->hasMany(Espacio::class);
    }

    public function secciones()
    {
        return $this->hasMany(Seccion::class);
    }

    // Relacion con el modelo de PNF
    public function pnfs()
    {
        return $this->belongsToMany(Pnf::class);
    }

    // Relacion con la tabla de municipios
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id_municipio');
    }
}
