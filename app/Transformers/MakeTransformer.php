<?php

namespace App\Transformers;

class MakeTransformer extends BaseTransformer
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
            'models' => collect($item->models),
            'products' => $item->products->count(),
            'created_at' => $item->created_at ? $item->created_at->toDateTimeString() : ''
        ];
    }
}
