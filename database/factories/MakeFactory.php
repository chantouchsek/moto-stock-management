<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Make::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'active' => $faker->boolean
    ];
});
