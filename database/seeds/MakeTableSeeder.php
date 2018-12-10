<?php

use Illuminate\Database\Seeder;

class MakeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Make::class, 10)->create();
    }
}
