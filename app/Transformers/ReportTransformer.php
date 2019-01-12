<?php

namespace App\Transformers;

class ReportTransformer extends BaseTransformer
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
            'created_at' => isset($item->created_at) ? $item->created_at->toDateString() : '',
            'customer' => $item->customer,
            'user' => $item->user,
            'product' => $item->product,
            'customer_name' => $item->customer_name,
            'price' => $item->price,
            'date' => isset($item->date) ? $item->date->toDateString() : '',
            'amount' => $item->amount,
            'files' => collect($item->getMedia('sale-attachment'))
        ];
    }
}
