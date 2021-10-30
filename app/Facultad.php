<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    protected $connection = 'DB_db_sga_SCHEMA_esq_inscripciones';

    protected $table = 'facultad';

    protected $primaryKey = 'idfacultad';

    public function escuelas()
    {
        return $this->hasMany(Escuela::class, 'idfacultad', 'idfacultad');
    }

    public function practicas()
    {
        return $this->hasMany(Practica::class, 'facultad_id', 'idfacultad');
    }
}
