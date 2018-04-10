<?php

use Faker\Generator as Faker;

$factory->define(App\Site::class, function (Faker $faker) {
    return [
        'domain' => $faker->domainName,
    ];
});
