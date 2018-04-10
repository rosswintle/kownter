<?php

use Faker\Generator as Faker;

$factory->define(App\ReferringDomain::class, function (Faker $faker) {
    return [
        'domain' => $faker->domainName,
    ];
});
