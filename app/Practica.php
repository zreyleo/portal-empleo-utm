<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practica extends Model
{
    protected $connection = 'DB_ppp_sistema_SCHEMA_esq_portal_empleos';

    protected $fillable = [
        'titulo', 'facultad_id', 'cupo', 'requerimientos', 'activa', 'empresa_id'
    ];

    protected $attributes = [
        'activa' => true,
        'cupo' => 1
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id_empresa');
    }
}
