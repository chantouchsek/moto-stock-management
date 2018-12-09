<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'username' => $faker->userName,
        'gender' => 1,
        'date_of_birth' => $faker->date('Y-m-d'),
        'bio' => $faker->text,
        'address' => $faker->address,
        'start_work_date' => $faker->date('Y-m-d'),
        'base_salary' => 500,
        'avatar_url' => $faker->imageUrl(),
        'status' => true,
        'resigned_at' => null,
        'bonus' => 20,
        'phone_number' => $faker->phoneNumber,
        'pay_day' => $faker->date('Y-m-d')
    ];
});
