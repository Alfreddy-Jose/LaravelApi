<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Espacio extends Model
{
    use Auditable;
    
    protected $fillable = [
        "codigo",
        "etapa",
        "nro_aula",
        "nombre_aula",
        "abreviado_lab",
        "equipos",
        "tipo_espacio",
        "sede_id"
    ];
    // Relación con el modelo Sede
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
}
