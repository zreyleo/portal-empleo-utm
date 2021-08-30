<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleo extends Model
{
    protected $connection = 'DB_ppp_sistema_SCHEMA_esq_portal_empleos';

    protected $table = 'empleos';

    protected $fillable = [
        'titulo', 'requerimientos', 'carrera_id', 'empresa_id'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id_empresa');
    }

    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'carrera_id', 'idescuela');
    }

    public function estudiantes_empleos()
    {
        return $this->hasMany(EstudianteEmpleo::class, 'empleo_id', 'id');
    }
}
