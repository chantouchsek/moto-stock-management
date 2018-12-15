<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ColorController extends Controller
{

    /**
     * @param Product $product
     * @param int $colorId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyColor(Product $product, $colorId)
    {
        $product->colors()->detach([$colorId]);
        return $this->respondCreated('Color deleted.');
    }
}
