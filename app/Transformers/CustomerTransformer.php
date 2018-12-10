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
            'date_of_birth' => isset($item->date_of_birth) ? $item->date_of_birth->toDateString() : ''
        ];
    }
}
