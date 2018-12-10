<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(SupplierTableSeeder::class);
        $this->call(MakeTableSeeder::class);
        $this->call(ModelsTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
    }
}
