<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_persona extends Model
{
    //
    protected $fillable = [
        'cedula_persona',
        'persona_id',
        'pnf_id',
        'lapso_id',
    ];


        // Relación con el modelo Persona
        public function persona()
        {
            return $this->belongsTo(Persona::class, 'persona_id');
        }
    
        // Relación con el modelo Pnf
        public function pnf()
        {
            return $this->belongsTo(Pnf::class, 'pnf_id');
        }
    
        // Relación con el modelo Lapso
        public function lapso()
        {
            return $this->belongsTo(LapsoAcademico::class, 'lapso_id');
        }
}
