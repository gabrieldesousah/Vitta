<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        //
    ];
});



$factory->define(App\exames_resultados::class, function (Faker $faker) {
    return [
        'laboratory' => $faker->city,
        'path_file' => str_random(10),
    ];
});