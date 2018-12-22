<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Expense::class, function (Faker $faker) {
    return [
        'amount' => rand(200, 5000),
        'date' => $faker->date('Y-m-d'),
        'expense_on' => $faker->text(255),
        'notes' => $faker->realText(),
        'user_id' => rand(1, 6)
    ];
});
