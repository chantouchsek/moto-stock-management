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
            'category_id' => (int)$item->category_id,
            'supplier_id' => (int)$item->supplier_id,
            'price' => (float)$item->price,
            'cost' => (float)$item->cost,
            'color' => (float)$item->color,
            'engine_number' => (string)$item->engine_number,
            'frame_number' => (string)$item->frame_number,
            'plate_number' => (string)$item->plate_number,
            'code' => (string)$item->code,
            'year' => (int)$item->year,
            'qty' => (int)$item->qty,
            'import_from' => (string)$item->import_from,
            'category' => $item->category,
            'model' => $item->model,
            'make' => $item->make,
            'supplier' => $item->supplier
        ];
    }
}
