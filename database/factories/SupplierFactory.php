<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Supplier::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone_number' => $faker->phoneNumber,
        'email' => $faker->email,
        'address' => $faker->address,
        'start_provide_date' => $faker->date('Y-m-d')
    ];
});
