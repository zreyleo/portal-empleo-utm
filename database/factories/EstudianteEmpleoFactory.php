<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EstudianteEmpleo;
use Faker\Generator as Faker;

$factory->define(EstudianteEmpleo::class, function (Faker $faker) {
    return [
        'estudiante_id' => $faker->numberBetween(66000, 66800),
        'empleo_id' => 1
    ];
});
