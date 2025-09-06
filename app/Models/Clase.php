<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sede;
use App\Models\Pnf;
use App\Models\Trayecto;
use App\Models\BloquesTurno;

class Clase extends Model
{
    protected $fillable = [
        'sede_id',
        'pnf_id',
        'trayecto_id',
        'trimestre_id',
        'unidad_curricular_id',
        'docente_id',
        'espacio_id',
        'bloque_id',
        'dia',
        'duracion'
    ];
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function pnf()
    {
        return $this->belongsTo(Pnf::class);
    }

    public function trayecto()
    {
        return $this->belongsTo(Trayecto::class);
    }
    public function trimestre()
    {
        return $this->belongsTo(Trimestre::class);
    }

    public function unidadCurricular()
    {
        return $this->belongsTo(UnidadCurricular::class);
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }
    public function espacio()
    {
        return $this->belongsTo(Espacio::class);
    }
    public function bloque()
    {
        return $this->belongsTo(BloquesTurno::class, 'bloque_id');
    }
}
