<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'uuid' => $faker->uuid,
        'slug' => $faker->slug,
        'description' => $faker->text,
        'active' => $faker->boolean
    ];
});
