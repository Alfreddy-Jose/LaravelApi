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
}
