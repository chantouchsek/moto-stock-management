<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Customer::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone_number' => $faker->phoneNumber,
        'address' => $faker->address,
        'email' => $faker->safeEmail,
        'date_of_birth' => $faker->date('Y-m-d')
    ];
});
