<?php

use Faker\Generator as Faker;

$factory->define(App\Paciente::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'document' => str_random(10),
        'password' => bcrypt(str_random(10))
    ];
});