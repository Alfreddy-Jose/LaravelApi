<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
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
        return $this->belongsTo(LapsoAcademico::class); 
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
}
