<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Loan::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 5),
        'staff_id' => rand(1, 5),
        'amount' => $faker->numberBetween(100, 500),
        'is_urgent' => $faker->boolean,
        'is_approved' => $faker->boolean,
        'reason' => $faker->realText(),
        'can_offer_on' => $faker->date('Y-m-d'),
        'needed_date' => $faker->date('Y-m-d')
    ];
});
