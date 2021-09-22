<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewEmpresa extends Model
{
    protected $connection = 'DB_ppp_sistema_SCHEMA_esq_portal_empleos';

    protected $table = 'nuevas_empresas';

    protected $primaryKey = 'id_empresa';

    protected $fillable = [
        'ruc', 'nombre_empresa', 'id_provincia', 'id_canton', 'id_parroquia',
        'direccion', 'email', 'telefono', 'descripcion', 'area', 'tipo', 'id_representante'
    ];

    protected $attributes = [
        'estado' => 1
    ];

    public function representante()
    {
        return $this->belongsTo(NewPersonalExterno::class, 'id_representante', 'id');
    }
}
