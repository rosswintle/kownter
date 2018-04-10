<?php

use Faker\Generator as Faker;

$factory->define(App\View::class, function (Faker $faker) {
    
    // Assume this week (but not today)
    $time = $faker->dateTimeBetween('-7 days', '-1 days');
    
    return [
        'created_at' => $time,
        'updated_at' => $time,
        'site_id' => 0,
        'user_agent_id' => 0,
        'page_id' => 0,
        'referring_domain_id' => null,
    ];

});
