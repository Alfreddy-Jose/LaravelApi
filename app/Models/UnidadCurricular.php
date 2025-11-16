<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class UnidadCurricular extends Model
{
    use Auditable;
    
    public $fillable = [
        "nombre",
        "descripcion",
        "unidad_credito",
        "hora_teorica",
        "hora_practica",
        "hora_total_est",
        "periodo",
    ];

    public function trimestres()
    {
        return $this->belongsToMany(Trimestre::class);
    }

    public function clases()
{
    return $this->hasMany(Clase::class, 'unidad_curricular_id');
}

    public function docentes()
    {
        return $this->belongsToMany(Docente::class);
    }
}
