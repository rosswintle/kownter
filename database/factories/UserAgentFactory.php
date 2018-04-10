<?php

use Faker\Generator as Faker;

$factory->define(App\UserAgent::class, function (Faker $faker) {
    return [
        'name' => $faker->userAgent,
    ];
});
