<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $connection = 'DB_ppp_sistema_SCHEMA_public';

    protected $table = 'tbl_empresa';

    protected $primaryKey = 'id_empresa';

    protected $hidden = [
        'password'
    ];

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
