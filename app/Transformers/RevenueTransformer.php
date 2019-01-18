<?php

namespace App\Transformers;


class RevenueTransformer extends BaseTransformer
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
            'total' => number_format(isset($item->total) ? $item->total : $item['total'], 2),
            'month' => isset($item->month) ? $item->month : $item['month'],
            'year' => isset($item->year) ? $item->year : $item['year']
        ];
    }
}
