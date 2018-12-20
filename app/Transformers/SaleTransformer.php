<?php

namespace App\Transformers;

use function GuzzleHttp\Psr7\str;

class SaleTransformer extends BaseTransformer
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
            'customer_id' => (int)$item->customer_id,
            'user_id' => (int)$item->user_id,
            'is_in_lack' => $item->is_in_lack,
            'in_lack_amount' => $item->in_lack_amount,
            'total' => (float)$item->total,
            'tax' => (int)$item->tax,
            'tax_amount' => (float)$item->tax_amount,
            'products' => collect($item->products)->map(function ($item) {
                return [
                    'id' => (int)$item->id,
                    'description' => (string)$item->description,
                    'name' => (string)$item->name,
                    'additional_price' => (float)$item->pivot->additional_price,
                    'discount' => (float)$item->pivot->discount,
                    'qty' => (int)$item->pivot->qty
                ];
            }),
            'created_at' => isset($item->created_at) ? $item->created_at->toDateString() : '',
            'customer' => $item->customer,
            'user' => $item->user
        ];
    }
}
