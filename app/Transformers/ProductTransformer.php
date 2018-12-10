<?php

namespace App\Transformers;

class ProductTransformer extends BaseTransformer
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
            'status' => (string)$item->status,
            'make_id' => (int)$item->make_id,
            'model_id' => (int)$item->model_id,
            'category_d' => (int)$item->category_id,
            'price' => (float)$item->price,
            'cost' => (float)$item->cost,
            'engine_number' => (string)$item->engine_number,
            'frame_number' => (string)$item->frame_number,
            'code' => (string)$item->code,
            'year' => (int)$item->year,
            'import_from' => (string)$item->import_from
        ];
    }
}
