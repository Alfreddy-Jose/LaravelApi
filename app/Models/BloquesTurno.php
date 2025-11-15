<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloquesTurno extends Model
{
    public $fillable = [
        'turno_id',
        'rango',
        'periodo',
        'tipo_turno'
    ];

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }
    public function clases()
    {
        return $this->hasMany(Clase::class, 'bloque_id');
    }

    public function scopeOrdenados($query)
    {
        return $query->with('turno')
            ->join('turnos', 'bloques_turnos.turno_id', '=', 'turnos.id')
            ->orderByRaw("
                CASE 
                    WHEN turnos.nombre LIKE '%MAÑANA%' THEN 1
                    WHEN turnos.nombre LIKE '%TARDE%' THEN 2
                    WHEN turnos.nombre LIKE '%NOCHE%' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('bloques_turnos.id')
            ->select('bloques_turnos.id', 'bloques_turnos.rango');
    }
}
