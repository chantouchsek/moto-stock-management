<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Role::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->slug,
        'description' => $faker->text,
        'status' => true
    ];
});
