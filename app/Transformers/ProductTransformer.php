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
            'qty' => (int)$item->qty,
            'import_from' => (string)$item->import_from,
            'category' => $item->category,
            'model' => $item->model,
            'make' => $item->make,
            'supplier' => $item->supplier,
            'colors' => collect($item->colors)->map(function ($color) {
                return [
                    'engineNumber' => $color->pivot->engine_number,
                    'plateNumber' => $color->pivot->plate_number,
                    'frameNumber' => $color->pivot->frame_number,
                    'code' => $color->pivot->code,
                    'soleOn' => $color->pivot->sole_on,
                    'name' => $color->name,
                    'colorId' => $color->id,
                    'status' => $color->pivot->status
                ];
            })
        ];
    }
}
