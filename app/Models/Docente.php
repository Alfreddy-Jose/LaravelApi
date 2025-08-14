<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    public $fillable = [
        'categoria',
        'pnf_id',
        'persona_id'
    ];

    public function condicionContrato()
    {
        return $this->hasOne(CondicionContrato::class);
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function unidades_curriculares()
    {
        return $this->belongsToMany(UnidadCurricular::class);
    }

    public function pnf()
    {
        return $this->belongsTo(Pnf::class);
    }

    
}
