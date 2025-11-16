<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Universidad extends Model
{
    use Auditable;

    protected $table = 'universidads';

    protected $fillable = [
        'nombre_univ',
        'abreviado_univ',
        'rif_univ',
        'direccion'
    ];
}
