<?php

use Faker\Generator as Faker;
use App\Entities\Signature;

$factory->define(Signature::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'body' => $faker->sentence
    ];
});
