<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Report\IndexRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Transformers\ReportTransformer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function groupByMake(IndexRequest $request)
    {
        if ($request->get('limit')) {
            $this->setPagination($request->get('limit'));
        }

        $fromDate = Carbon::now()->addDay(-7)->toDateString();
        $tillDate = Carbon::now()->subDay()->toDateString();

        $pagination = Product::search($request->get('q'), null, true)
            ->whereBetween(DB::raw('date(date_import)'), [$fromDate, $tillDate])
            ->with(['make'])
            ->orderBy('make_id')
            ->get();

        $data = collect($pagination);

        $reportBuys = $data->groupBy('make.name')->map(function ($row) {
            return [
                'total_price' => number_format($row->sum->price, 2),
                'total_rows' => $row->count(),
                'products' => $row->map(function ($item) {
                    return [
                        'name' => $item['name'],
                        'price' => $item['price']
                    ];
                })
            ];
        });

        return $this->respond(['data' => $reportBuys]);
    }
}
