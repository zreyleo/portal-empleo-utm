<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleo extends Model
{
    protected $fillable = [
        'titulo', 'requerimientos', 'carrera_id', 'empresa_id'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
