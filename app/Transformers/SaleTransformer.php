<?php

namespace App\Transformers;

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
            'is_in_lack' => $item->is_in_lack,
            'in_lack_amount' => $item->in_lack_amount,
            'total' => (float)$item->total,
            'tax' => (int)$item->tax,
            'tax_amount' => (float)$item->tax_amount,
            'products' => collect($item->products)
        ];
    }
}
