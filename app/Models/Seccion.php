<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    public function trayecto()
    {
        return $this->belongsTo(Trayecto::class);
    }
}
