<?php

namespace App\Transformers;

class PayrollTransformer extends BaseTransformer
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
            'user_id' => (int)$item->user_id,
            'staff_id' => (int)$item->staff_id,
            'over_time' => (boolean)$item->over_time,
            'hours' => (int)$item->hours,
            'total' => number_format($item->total, 2),
            'cross' => number_format($item->cross, 2),
            'notified' => (boolean)$item->notified
        ];
    }
}
