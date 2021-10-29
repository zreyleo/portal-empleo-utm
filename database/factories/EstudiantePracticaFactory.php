<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EstudiantePractica;
use Faker\Generator as Faker;

$factory->define(EstudiantePractica::class, function (Faker $faker) {
    return [
        'estudiante_id' => 66710, // id of Regynald Zambrano
        'practica_id' => 1
    ];
});
