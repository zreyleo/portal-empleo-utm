<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Practica;
use Faker\Generator as Faker;

$factory->define(Practica::class, function (Faker $faker) {
    $random_empresas_ids = array(2, 5, 8, 10, 14, 23, 44, 81);

    $data_factory = [
        [
            'Se necesita tecnicos en computadoras',
            2
        ],
        [
            'Se necesita tecnicos en topografia',
            1
        ],
        [
            'Se estudiantes de docencia',
            3
        ],
        [
            'Se necesita estudiantes de agronomia',
            5
        ],
        [
            'Se necesita pasantes de economia',
            8
        ],
    ];

    $random_key_of_data_factory = array_rand($data_factory);

    return [
        'titulo' => $data_factory[$random_key_of_data_factory][0],
        'requerimientos' => $faker->text,
        'facultad_id' => $data_factory[$random_key_of_data_factory][1],
        'empresa_id' => $random_empresas_ids[array_rand($random_empresas_ids)],
    ];
});
