<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Sale::class, function (Faker $faker) {
    return [
        'is_in_lack' => $faker->boolean,
        'in_lack_amount' => $faker->numberBetween(1, 100),
        'total' => $faker->numberBetween(200, 500),
        'tax' => 0,
        'tax_amount' => 0,
        'user_id' => rand(1, 5),
        'customer_id' => rand(1, 10),
        'product_id' => rand(1, 500),
        'price' => $faker->numberBetween(300, 1000),
        'date' => $faker->date('Y-m-d'),
        'customer_name' => $faker->name,
        'amount' => $faker->numberBetween(200, 1200)
    ];
});
