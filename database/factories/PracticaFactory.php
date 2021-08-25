<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Practica;
use Faker\Generator as Faker;

$factory->define(Practica::class, function (Faker $faker) {
    $random_empresas_ids = array(2, 5, 8, 10, 14, 23, 44, 81);

    $random_practicas_titles = array(
        'Se necesita tecnicos en computadoras',
        'Se necesita tecnicos en topografia',
        'Se aceptan pasantes en contabilidad',
        'Se aceptan de agronomia',
        'Se aceptan para procesos industriales',
    );

    return [
        'titulo' => $random_practicas_titles[array_rand($random_practicas_titles)],
        'requerimientos' => $faker->text,
        'facultad_id' => $faker->numberBetween(1, 11),
        'empresa_id' => $random_empresas_ids[array_rand($random_empresas_ids)],
    ];
});
