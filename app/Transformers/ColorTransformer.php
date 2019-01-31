<?php

namespace App\Transformers;

class ColorTransformer extends BaseTransformer
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
            'name' => (string)$item->name,
            'description' => $item->description,
            'active' => (int)$item->active,
            'products' => collect($item->products),
            'products_count' => $item->products->count()
        ];
    }
}
