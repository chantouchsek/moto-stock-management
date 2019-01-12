<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Report\IndexRequest;
use App\Models\Sale;
use App\Transformers\ReportTransformer;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * @var ReportTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * ReportController constructor.
     * @param ReportTransformer $transformer The transformer used to transform the model
     */
    public function __construct(ReportTransformer $transformer)
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

        $pagination = Sale::search($request->get('q'), null, true)->paginate($this->getPagination());

        $data = $this->transformer->transformCollection(collect($pagination->items()));

        return $this->respondWithPagination($pagination, [
            'data' => $data
        ]);
    }
}
