<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacoras';

    protected $fillable = [
        'user_id',
        'accion',
        'tabla',
        'registro_id',
        'datos_anteriores',
        'datos_nuevos',
    ];

    // Relación con usuario (para ver quién hizo el cambio)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
