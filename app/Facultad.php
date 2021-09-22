<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    protected $connection = 'DB_db_sga_SCHEMA_esq_inscripciones';

    protected $table = 'facultad';

    protected $primaryKey = 'idfacultad';
}
