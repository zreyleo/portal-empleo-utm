<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EstudianteEmpleo;
use Faker\Generator as Faker;

$factory->define(EstudianteEmpleo::class, function (Faker $faker) {
    return [
        'estudiante_id' => $faker->numberBetween(66709, 66711),
        'empleo_id' => 1
    ];
});
