<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pnf extends Model
{
    //
    protected $fillable = [
        'codigo',
        'nombre',
        'abreviado',
        'abreviado_coord'
    ];
}
