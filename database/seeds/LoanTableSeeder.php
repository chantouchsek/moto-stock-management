<?php

use Illuminate\Database\Seeder;

class LoanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Loan::class, 10)->create();
    }
}
