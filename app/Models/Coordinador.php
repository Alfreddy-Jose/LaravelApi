<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    protected $table = 'coordinadors';

    protected $fillable = [
        'docente_id',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }
}
