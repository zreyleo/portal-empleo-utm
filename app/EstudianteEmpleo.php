<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstudianteEmpleo extends Model
{
    protected $table = 'estudiantes_empleos';

    protected $fillable = [
        'estudiante_id', 'empleo_id'
    ];
}
