<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $connection = 'DB_db_sga_actual';

    protected $table = 'esq_datos_personales.personal';

    protected $primaryKey = 'idpersonal';

    public function getNombresCompletosAttribute()
    {
        return $this->apellido1 . " " . $this->apellido2 . " " . $this->nombres;
    }

    public function perfil()
    {
        return $this->hasOne(Perfil::class, 'personal_id', 'idpersonal');
    }
}
