<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Requests\Admin\Sale\IndexRequest;
use App\Models\Sale;
use App\Traits\Authorizable;
use App\Transformers\SaleHistoryTransformer;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    use Authorizable;

    /**
     * @var SaleHistoryTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * SaleController constructor.
     * @param SaleHistoryTransformer $transformer The transformer used to transform the model
     */
    public function __construct(SaleHistoryTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @param Sale $sale
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request, Sale $sale)
    {
        if ($request->get('limit')) {
            $this->setPagination($request->get('limit'));
        }

        $pagination = $sale->revisionHistory()->paginate($this->getPagination());

        $data = $this->transformer->transformCollection(collect($pagination->items()));

        return $this->respondWithPagination($pagination, [
            'data' => [
                'revisions' => $data,
                'sale' => $sale
            ]
        ]);
    }
}
