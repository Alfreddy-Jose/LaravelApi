<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use Auditable;
    
    protected $fillable = [
        'nombre',
        'numero'
    ];

    public function secciones()
    {
        return $this->hasMany(Seccion::class);
    }
}
