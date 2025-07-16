<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $fillable = [
        'nombre',
        'numero'
    ];

    public function secciones()
    {
        return $this->hasMany(Seccion::class);
    }
}
