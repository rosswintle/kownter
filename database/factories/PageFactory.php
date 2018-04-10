<?php

use Faker\Generator as Faker;

$factory->define(App\Page::class, function (Faker $faker) {

    return [
        'url' => $faker->url(),
        'site_id' => 0,
    ];
    
});
