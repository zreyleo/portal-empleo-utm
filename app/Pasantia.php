<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasantia extends Model
{
    const CREATED_AT = 'fecha_sistema';

    protected $connection = 'DB_ppp_sistema_SCHEMA_public';

    protected $table = 'tbl_pasantia';

    protected $primaryKey = 'id_pasantia';

    protected $fillable = [
        'id_pasante', 'id_supervisor', 'id_empresa', 'horas', 'id_carrera', 'titulo_pasantia', 'id_periodo',
        'id_materia_unica', 'id_malla', 'fase'
    ];

    public $timestamps = false;

    public function estudiante_practica()
    {
        return $this->hasOne(EstudiantePractica::class, 'pasantia_id', 'id_pasantia');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_pasantia', 'id_pasantia');
    }

    public function  empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }
}
