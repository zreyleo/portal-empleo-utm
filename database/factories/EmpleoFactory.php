<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Empleo;
use Faker\Generator as Faker;

$factory->define(Empleo::class, function (Faker $faker) {
    $random_empresas_ids = array(2, 5, 8, 10, 14, 23, 44, 81);
    return [
        'titulo' => $faker->sentence,
        'requerimientos' => $faker->text,
        'carrera_id' => $faker->numberBetween(1, 20),
        'empresa_id' => $random_empresas_ids[array_rand($random_empresas_ids)],
    ];
});
