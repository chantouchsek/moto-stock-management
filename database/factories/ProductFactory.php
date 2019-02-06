<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'make_id' => rand(1, 10),
        'color_id' => rand(1, 3),
        'model_id' => rand(1, 10),
        'supplier_id' => rand(1, 10),
        'description' => $faker->text,
        'price' => $faker->numberBetween(200, 5000),
        'cost' => $faker->numberBetween(100, 4000),
        'year' => $faker->date('Y'),
        'import_from' => $faker->country,
        'engine_number' => $faker->unique()->randomNumber(),
        'frame_number' => $faker->unique()->randomNumber(),
        'status' => $faker->randomElement(['new', 'second_hand']),
        'code' => $faker->postcode,
        'date_import' => $faker->date('Y-m-d'),
        'engine_size' => $faker->randomNumber()
    ];
});
