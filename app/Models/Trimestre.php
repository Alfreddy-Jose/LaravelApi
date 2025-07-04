<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trimestre extends Model
{
    use HasFactory;

    public function unidadCurriculares()
    {
        return $this->hasMany(UnidadCurricular::class);
    }
}
