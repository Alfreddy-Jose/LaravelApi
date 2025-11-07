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
/*    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'pnf_id');
    }  */

    public function docentes()
    {
        return $this->hasMany(Docente::class);
    }

    // Relación muchos a muchos con el modelo Sede
    public function sedes()
    {
        return $this->belongsToMany(Sede::class);
    }
}
