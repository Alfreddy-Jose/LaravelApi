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
}
