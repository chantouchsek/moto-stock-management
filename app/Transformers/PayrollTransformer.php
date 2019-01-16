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
            'gross' => number_format($item->gross, 2),
            'notified' => (boolean)$item->notified,
            'created_at' => isset($item->created_at) ? $item->created_at->toDateString() : '',
            'staff' => $item->staff,
            'paid_by' => $item->paidBy
        ];
    }
}
