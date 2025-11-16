<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class LapsoAcademico extends Model
{
    use Auditable; 

    protected $fillable = [
        'nombre_lapso',
        'ano',
        'tipo_lapso_id',
        'fecha_inicio',
        'fecha_fin',
        'status'
    ];

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
