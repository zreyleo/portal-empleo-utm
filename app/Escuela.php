<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    protected $connection = 'DB_db_sga_SCHEMA_esq_inscripciones';

    protected $table = 'escuela';

    protected $primaryKey = 'idescuela';

    public function empleos()
    {
        return $this->hasMany(Empleo::class, 'carrera_id', 'idescuela');
    }
}
