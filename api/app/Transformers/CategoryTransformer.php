<?php

namespace App\Transformers;

class CategoryTransformer extends BaseTransformer
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
            'name' => (string)$item->name,
            'slug' => (string)$item->slug,
            'description' => $item->description,
            'active' => (boolean)$item->status
        ];
    }
}
