<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Seccion extends Model
{
    use Auditable;

    protected $fillable = [
        'pnf_id',
        'matricula_id',
        'trayecto_id',
        'sede_id',
        'numero_seccion',
        'lapso_id'
    ];

    public function horarios()
{
    return $this->hasMany(Horario::class);
}

    public function trayecto()
    {
        return $this->belongsTo(Trayecto::class);
    }

    public function pnf()
    {
        return $this->belongsTo(Pnf::class);
    }

    // Relación con el modelo LapsoAcademico
    public function lapso()
    {
        return $this->belongsTo(LapsoAcademico::class, 'lapso_id');
    }

    // Relación con el modelo Sede
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
    // Relación con el modelo Matricula
    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }

    // Relación con el modelo Vocero
    public function vocero()
    {
        return $this->hasOne(Vocero::class);
    }
}
