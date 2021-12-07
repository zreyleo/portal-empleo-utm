<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasantia extends Model
{
    public $timestamps = false;

    protected $connection = 'DB_ppp_sistema_SCHEMA_public';

    protected $table = 'tbl_pasantia';

    protected $primaryKey = 'id_pasantia';

    protected $fillable = [
        'id_pasante', 'id_empresa', 'horas', 'id_carrera', 'titulo_pasantia', 'id_periodo',
        'id_materia_unica', 'id_malla', 'fase'
    ];
}
