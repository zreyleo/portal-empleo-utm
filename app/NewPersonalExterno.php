<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewPersonalExterno extends Model
{
    protected $connection = 'DB_ppp_sistema_SCHEMA_esq_portal_empleos';

    protected $table = 'nuevo_personal_externo';

    protected $fillable = [
        'cedula', 'apellido_p', 'apellido_m', 'nombres', 'titulo', 'genero'
    ];

    protected $attributes = [
        'estado' => 1
    ];

    public function getNombresCompletosAttribute()
    {
        return $this->apellido_p . " " . $this->apellido_m . " " . $this->nombres;
    }

    public function empresa()
    {
        return $this->hasOne(NewEmpresa::class, 'id_representante', 'id');
    }
}
