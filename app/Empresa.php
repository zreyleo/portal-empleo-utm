<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $connection = 'DB_ppp_sistema_SCHEMA_public';

    protected $table = 'tbl_empresa';

    protected $primaryKey = 'id_empresa';

    protected $fillable = [
        'nombre_empresa', 'id_provincia', 'id_canton', 'id_parroquia', 'direccion', 'id_representante',
        'tipo', 'telefono', 'email', 'password', 'ruc', 'descripcion', 'area', 'registrado_por'
    ];

    protected $attributes = [
        'estado' => 1
    ];

    protected $hidden = [
        'password'
    ];

    public $timestamps = false;

    public function getSlugAttribute()
    {
        return str_replace(' ', '-', strtolower($this->nombre_empresa));
    }

    public function empleos()
    {
        return $this->hasMany(Empleo::class, 'empresa_id', 'id_empresa');
    }

    public function practicas()
    {
        return $this->hasMany(Practica::class, 'empresa_id', 'id_empresa');
    }
}
