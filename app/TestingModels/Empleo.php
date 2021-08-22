<?php

namespace App\TestingModels;

use Illuminate\Database\Eloquent\Model;

class Empleo extends Model
{
    protected $connection = 'DB_ppp_sistema_SCHEMA_esq_portal_empleos_TESTS';

    protected $table = 'empleos';

    protected $fillable = [
        'titulo', 'requerimientos', 'carrera_id', 'empresa_id'
    ];

    public function empresa()
    {
        return $this->belongsTo(App\Empresa::class, 'empresa_id', 'id_empresa');
    }
}
