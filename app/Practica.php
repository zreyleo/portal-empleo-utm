<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practica extends Model
{
    protected $connection = 'DB_ppp_sistema_SCHEMA_esq_portal_empleos';

    protected $fillable = [
        'titulo', 'facultad_id', 'cupo', 'requerimientos', 'visible', 'empresa_id'
    ];

    protected $attributes = [
        'visible' => true,
        'cupo' => 1
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id_empresa');
    }

    public function estudiantes_practicas()
    {
        return $this->hasMany(EstudiantePractica::class, 'practica_id', 'id');
    }

    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'facultad_id', 'idfacultad');
    }

    public function pasantias()
    {
        return $this->belongsToMany(Pasantia::class, 'esq_portal_empleos.estudiantes_practicas', 'practica_id', 'pasantia_id');
    }
}
