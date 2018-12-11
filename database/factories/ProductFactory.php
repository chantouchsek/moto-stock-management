<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'make_id' => rand(1, 10),
        'model_id' => rand(1, 10),
        'supplier_id' => rand(1, 10),
        'category_id' => rand(1, 10),
        'description' => $faker->text,
        'price' => $faker->numberBetween(200, 5000),
        'cost' => $faker->numberBetween(100, 4000),
        'qty' => rand(5, 20),
        'engine_number' => $faker->numberBetween(20, 50),
        'color' => $faker->safeColorName,
        'plate_number' => 'P-' . $faker->numberBetween(4, 4),
        'frame_number' => $faker->numberBetween(30, 50),
        // 'status' => $faker->shuffle(['new', 'second_hand']),
        'code' => $faker->countryCode,
        'year' => $faker->date('Y'),
        'import_from' => $faker->country
    ];
});
