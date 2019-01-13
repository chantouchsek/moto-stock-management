<?php

namespace App\Transformers;

class CustomerTransformer extends BaseTransformer
{

    /**
     * Method used to transform an item.
     *
     * @param $item mixed The item to be transformed.
     *
     * @return array The transformed item.
     */
    public function transform($item): array
    {
        return [
            'id' => (int)$item->id,
            'uuid' => (string)$item->uuid,
            'full_name' => (string)$item->full_name,
            'first_name' => (string)$item->first_name,
            'last_name' => (string)$item->last_name,
            'email' => (string)$item->email,
            'phone_number' => (string)$item->phone_number,
            'address' => (string)$item->address,
            'registered_date' => isset($item->created_at) ? $item->created_at->toDateString() : '',
            'date_of_birth' => isset($item->date_of_birth) ? $item->date_of_birth->toDateString() : '',
            'total_price' => number_format(collect($item->purchases)->sum('price'), 2),
            'purchases' => collect($item->purchases)->map(function ($item) {
                return [
                    'price' => number_format($item->price, 2),
                    'date' => isset($item->date) ? $item->date->toDateString() : '',
                    'total' => number_format($item->total, 2),
                    'product' => $item->product
                ];
            }),
            'last_purchased' => count($item->purchases) ? collect($item->purchases)->sortByDesc('date')->first()->date->toDateString() : ''
        ];
    }
}
