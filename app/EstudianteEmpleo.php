<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstudianteEmpleo extends Model
{
    protected $table = 'estudiantes_empleos';

    protected $fillable = [
        'estudiante_id', 'empleo_id'
    ];

    public function empleo()
    {
        return $this->belongsTo(Empleo::class, 'empleo_id', 'id');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'estudiante_id', 'idpersonal');
    }
}
