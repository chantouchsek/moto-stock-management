<?php

namespace App\Transformers;

class ModelsTransformer extends BaseTransformer
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
            'make_id' => (int)$item->make_id,
            'name' => (string)$item->name,
            'description' => $item->description,
            'active' => (int)$item->active,
            'make' => $item->make,
            'products' => $item->products->count()
        ];
    }
}
