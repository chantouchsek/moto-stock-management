<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Models::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'active' => $faker->boolean,
        'make_id' => rand(1, 10)
    ];
});
