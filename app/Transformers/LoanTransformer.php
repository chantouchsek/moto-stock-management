<?php

namespace App\Transformers;

class LoanTransformer extends BaseTransformer
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
            'approved_by' => $item->approvedBy,
            'staff' => $item->staff,
            'user_id' => $item->user_id,
            'staff_id' => $item->staff_id,
            'is_approved' => (boolean)$item->is_approved,
            'is_urgent' => (boolean)$item->is_urgent,
            'amount' => $item->amount,
            'reason' => (string)$item->reason,
            'needed_date' => isset($item->needed_date) ? $item->needed_date->toDateString() : '',
            'can_offer_on' => isset($item->can_offer_on) ? $item->can_offer_on->toDateString() : '',
            'created_at' => isset($item->created_at) ? $item->created_at->toDateString() : '',
            'can_edit' => (boolean)$item->can_edit
        ];
    }
}
