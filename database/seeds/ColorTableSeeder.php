<?php

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            [
                'name' => 'Black',
                'description' => 'Color Black',
                'active' => true
            ],
            [
                'name' => 'White',
                'description' => 'Color White',
                'active' => true
            ],
            [
                'name' => 'Red',
                'description' => 'Color Red',
                'active' => true
            ]
        ];
        // create colors
        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
