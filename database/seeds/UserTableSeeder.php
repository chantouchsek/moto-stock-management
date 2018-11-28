<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
            'username' => 'admin.user',
            'role_id' => 1,
            'gender' => 1,
            'date_of_birth' => '2014-09-23',
            'address' => 'Phnom Penh',
            'start_work_date' => '2017-09-23',
            'base_salary' => 700,
            'avatar_url' => 'https://lorempixel.com/640/480/?16302',
            'status' => true,
            'resigned_at' => null,
            'bonus' => 20,
            'phone_number' => '093234923'
        ]);
        factory(\App\Models\User::class, 5)->create();
    }
}
