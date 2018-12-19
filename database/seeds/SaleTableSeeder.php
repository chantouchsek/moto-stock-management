<?php

use Illuminate\Database\Seeder;

class SaleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Sale::class, 50)->create();

        $sales = \App\Models\Sale::all();

        foreach ($sales as $index => $sale) {
            $array = [];
            $products = [
                [
                    'productId' => rand(1, 5),
                    'qty' => rand(1, 5),
                    'discount' => 0,
                    'additional_price' => 0
                ],
                [
                    'productId' => rand(1, 5),
                    'qty' => rand(1, 5),
                    'discount' => 0,
                    'additional_price' => 0
                ]
            ];
            foreach ($products as $key => $product) {
                $array[$product['productId']] = [
                    'qty' => $product['qty'],
                    'discount' => $product['discount'],
                    'additional_price' => $product['additional_price']
                ];
            }

            $sale->products()->attach($array);
        }
    }
}
