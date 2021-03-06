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
            'make_id' => (int)$item->make_id,
            'model_id' => (int)$item->model_id,
            'category_id' => (int)$item->category_id,
            'supplier_id' => (int)$item->supplier_id,
            'price' => (float)$item->price,
            'cost' => (float)$item->cost,
            'year' => (int)$item->year,
            'category' => $item->category,
            'model' => $item->model,
            'make' => $item->make,
            'color' => $item->color,
            'supplier' => $item->supplier,
            'date_import' => isset($item->date_import) ? $item->date_import->toDateString() : '',
            'engine_number' => (string)$item->engine_number,
            'plate_number' => (string)$item->plate_number,
            'frame_number' => (string)$item->frame_number,
            'sole_on' => isset($item->sole_on) ? $item->sole_on->toDateString() : '',
            'color_id' => (int)$item->color_id,
            'status' => (string)$item->status,
            'file' => $item->hasMedia('product-image-featured') ? config('app.url') . $item->getMedia('product-image-featured')->first()->getUrl('product-image-featured') : '',
            'engine_size' => (string)$item->engine_size
        ];
    }
}
