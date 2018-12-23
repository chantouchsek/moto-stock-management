<?php

namespace App\Transformers;

class ExpenseTransformer extends BaseTransformer
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
            'amount' => (float)$item->amount,
            'expense_on' => (string)$item->expense_on,
            'notes' => (string)$item->notes,
            'user_id' => (int)$item->user_id,
            'user' => $item->user,
            'date' => isset($item->date) ? $item->date->toDateString() : '',
            'files' => collect($item->getMedia('attachments'))
        ];
    }
}
