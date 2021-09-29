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

    public function setApellidoPAttribute($value)
    {
        $this->attributes['apellido_p'] = strtoupper($value);
    }

    public function setApellidoMAttribute($value)
    {
        $this->attributes['apellido_m'] = strtoupper($value);
    }

    public function setNombresAttribute($value)
    {
        $this->attributes['nombres'] = strtoupper($value);
    }

    public function setTituloAttribute($value)
    {
        $this->attributes['titulo'] = strtoupper($value);
    }

    public function getNombresCompletosAttribute()
    {
        return $this->apellido_p . " " . $this->apellido_m . " " . $this->nombres;
    }

    public function empresa()
    {
        return $this->hasOne(NewEmpresa::class, 'id_representante', 'id');
    }
}
