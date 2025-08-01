<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadCurricular extends Model
{
    public $fillable = [
        "nombre",
        "descripcion",
        "unidad_credito",
        "hora_acad",
        "hora_total_est",
        "periodo",
        "trimestre_id"
    ];

    public function trimestre()
    {
        return $this->belongsTo(Trimestre::class);
    }

    public function docentes()
    {
        return $this->belongsToMany(Docente::class);
    }
}
