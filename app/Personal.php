<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $connection = 'DB_db_sga_SCHEMA_esq_centralizado';

    protected $table = 'personal';

    protected $primaryKey = 'idpersonal';

    public function getNombresCompletosAttribute()
    {
        return $this->apellido . " " . $this->apellido2 . " " . $this->nombres;
    }
}
