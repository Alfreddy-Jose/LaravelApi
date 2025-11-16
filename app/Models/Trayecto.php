<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Trayecto extends Model
{
    use Auditable;
    
    public $fillable = [
        'nombre'
    ];

    public function secciones()
    {
        return $this->hasMany(Seccion::class);
    }

    public function trimestres()
    {
        return $this->hasMany(Trimestre::class);
    }
}
