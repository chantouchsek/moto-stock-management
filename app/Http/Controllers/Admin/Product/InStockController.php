<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Requests\Admin\Product\IndexRequest;
use App\Models\Product;
use App\Traits\Authorizable;
use App\Transformers\ProductTransformer;
use App\Http\Controllers\Controller;

class InStockController extends Controller
{
    use Authorizable;
    /**
     * @var ProductTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * ProductController constructor.
     * @param ProductTransformer $transformer The transformer used to transform the model
     */
    public function __construct(ProductTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request)
    {
        if ($request->get('limit')) {
            $this->setPagination($request->get('limit'));
        }

        $q = $request->get('q');
        $categoryId = $request->get('category_id');

        $pagination = Product::search($q, null, false)
            ->whereNull('sole_on')
            ->when($categoryId, function ($query, $q) {
                return $query->where('category_id', $q);
            })
            ->when($request->get('make_id'), function ($query, $q) {
                return $query->where('make_id', $q);
            })
            ->when($request->get('supplier_id'), function ($query, $q) {
                return $query->where('supplier_id', $q);
            })
            ->when($request->get('model_id'), function ($query, $q) {
                return $query->where('model_id', $q);
            })
            ->when($request->get('color_id'), function ($query, $q) {
                return $query->where('color_id', $q);
            })
            ->when($request->get('status'), function ($query, $q) {
                return $query->where('status', $q);
            });

        $pagination = $pagination->paginate($this->getPagination());

        $data = $this->transformer->transformCollection(collect($pagination->items()));

        return $this->respondWithPagination($pagination, ['data' => $data]);
    }
}
