<?php

use Illuminate\Database\Seeder;
use App\Models\Models;

class ModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = [
            [
                'name' => 'Thunderbolt',
                'make_id' => '4',
                'description' => 'Thunderbolt',
                'active' => 1
            ], [
                'name' => 'Venom',
                'make_id' => '14',
                'description' => 'Venom',
                'active' => 1
            ], [
                'name' => 'Spitfire',
                'make_id' => '5',
                'description' => 'Spitfire',
                'active' => 1
            ], [
                'name' => 'Interceptor',
                'make_id' => '8',
                'description' => 'Interceptor',
                'active' => 1
            ], [
                'name' => 'Lightning',
                'make_id' => '5',
                'description' => 'Lightning',
                'active' => 1
            ], [
                'name' => 'Ninja',
                'make_id' => '9',
                'description' => 'Ninja',
                'active' => 1
            ], [
                'name' => 'Victor 441',
                'make_id' => '5',
                'description' => 'Victor 441',
                'active' => 1
            ], [
                'name' => 'Super Glide',
                'make_id' => '7',
                'description' => 'Super Glide',
                'active' => 1
            ], [
                'name' => 'Rocket III',
                'make_id' => '5',
                'description' => 'Trail 90',
                'active' => 1
            ], [
                'name' => 'Katana',
                'make_id' => '11',
                'description' => 'Katana',
                'active' => 1
            ], [
                'name' => 'Super Hawk',
                'make_id' => '8',
                'description' => 'Super Hawk',
                'active' => 1
            ], [
                'name' => 'Road King',
                'make_id' => '7',
                'description' => 'Road King',
                'active' => 1
            ], [
                'name' => 'Avenger',
                'make_id' => '9',
                'description' => 'Avenger',
                'active' => 1
            ], [
                'name' => 'Intruder',
                'make_id' => '11',
                'description' => 'Intruder',
                'active' => 1
            ], [
                'name' => 'Trail 90',
                'make_id' => '8',
                'description' => 'Trail 90',
                'active' => 1
            ], [
                'name' => 'Bandit',
                'make_id' => '11',
                'description' => 'Bandit',
                'active' => 1
            ], [
                'name' => 'Magna',
                'make_id' => '11',
                'description' => 'Magna',
                'active' => 1
            ], [
                'name' => 'Sportster',
                'make_id' => '7',
                'description' => 'Sportster',
                'active' => 1
            ], [
                'name' => 'Black Bird',
                'make_id' => '8',
                'description' => 'Black Bird',
                'active' => 1
            ], [
                'name' => 'Formula 3',
                'make_id' => '6',
                'description' => 'Formula 3',
                'active' => 1
            ], [
                'name' => 'V-Max',
                'make_id' => '15',
                'description' => 'V-Max',
                'active' => 1
            ], [
                'name' => 'Scat',
                'make_id' => '7',
                'description' => 'Scat',
                'active' => 1
            ], [
                'name' => 'FireBlade',
                'make_id' => '8',
                'description' => 'FireBlade',
                'active' => 1
            ], [
                'name' => 'Beagle',
                'make_id' => '5',
                'description' => 'Beagle',
                'active' => 1
            ], [
                'name' => 'Virago',
                'make_id' => '15',
                'description' => 'Virago',
                'active' => 1
            ], [
                'name' => 'Fire Storm',
                'make_id' => '8',
                'description' => 'Fire Storm',
                'active' => 1
            ], [
                'name' => 'TransAlp',
                'make_id' => '8',
                'description' => 'TransAlp',
                'active' => 1
            ], [
                'name' => 'Topper',
                'make_id' => '7',
                'description' => 'Topper',
                'active' => 1
            ], [
                'name' => 'Varadero',
                'make_id' => '8',
                'description' => 'Varadero',
                'active' => 1
            ], [
                'name' => 'Shadow',
                'make_id' => '8',
                'description' => 'Shadow',
                'active' => 1
            ], [
                'name' => 'Vision',
                'make_id' => '15',
                'description' => 'Vision',
                'active' => 1
            ], [
                'name' => 'Hayabusa',
                'make_id' => '11',
                'description' => 'Hayabusa',
                'active' => 1
            ], [
                'name' => 'Torpedo',
                'make_id' => '6',
                'description' => 'Torpedo',
                'active' => 1
            ], [
                'name' => 'Diana',
                'make_id' => '6',
                'description' => 'Diana',
                'active' => 1
            ], [
                'name' => 'Desmo',
                'make_id' => '6',
                'description' => 'Desmo',
                'active' => 1
            ], [
                'name' => 'Hummer',
                'make_id' => '6',
                'description' => 'Hummer',
                'active' => 1
            ], [
                'name' => 'DREAM125',
                'make_id' => '9',
                'description' => 'HONDA DREAM125',
                'active' => 1
            ],
        ];
        foreach ($models as $model) {
            Models::create($model);
        }
    }
}
