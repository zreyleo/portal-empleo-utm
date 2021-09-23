<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalExterno extends Model
{
    protected $connection = 'DB_ppp_sistema_SCHEMA_public';

    protected $table = 'tbl_personal_externo';

    protected $primaryKey = 'id_personal_externo';

    protected $fillable = [
        'cedula', 'nombres', 'apellido1', 'apellido2', 'titulo', 'genero', 'fecha_nacimiento'
    ];

    protected $attributes = [
        'estado' => 1
    ];

    public $timestamps = false;

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'id_representante', 'id_personal_externo');
    }
}
