<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Report\IndexRequest;
use App\Models\Expense;
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

        $query = (int)$request->input('q');

        $fromDate = $request->has('date') ? Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d') : Carbon::now()->addDay(-$query)->toDateString();
        $tillDate = Carbon::now()->subDay()->toDateString();

        $products = Product::whereBetween(DB::raw('date(date_import)'), [$fromDate, $tillDate])
            ->with(['make'])
            ->orderBy('make_id')
            ->get();

        $dataProducts = collect($products);

        $reportBuys = $dataProducts->groupBy('make.name')->map(function ($row) {
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

        $sales = Sale::whereBetween(DB::raw('date(date)'), [$fromDate, $tillDate])
            ->with(['product.make', 'product.model'])
            ->orderBy('product_id')
            ->get();

        $dataSales = collect($sales);

        $reportSales = $dataSales->groupBy('product.make.name')->map(function ($row) {
            return [
                'total_price' => number_format($row->sum->price, 2),
                'total_rows' => $row->count(),
                'products' => $row->map(function ($item) {
                    return [
                        'name' => $item->product->name,
                        'price' => $item->price,
                        'date' => isset($item->date) ? $item->date->toDateString() : ''
                    ];
                })
            ];
        });

        $expenses = Expense::whereBetween(DB::raw('date(date)'), [$fromDate, $tillDate])
            ->with(['user'])
            ->orderBy('date')
            ->get();

        $dataExpenses = collect($expenses);

        $reportExpenses = $dataExpenses->groupBy(function ($proj) {
            return $proj->date->format('Y');
        })->map(function ($year) {
            return number_format($year->sum('amount'), 2);
        });

        $totalExpenses = number_format($expenses->sum('amount'), 2);
        $totalSales = number_format($sales->sum('price'), 2);
        $totalBuys = number_format($dataProducts->sum('price'), 2);
        $totalBuyProducts = number_format($dataProducts->count(), 0);
        $totalSalesProducts = number_format($sales->count(), 0);

        return $this->respond([
            'data' => [
                'buys' => $reportBuys,
                'sales' => $reportSales,
                'expenses' => $reportExpenses,
                'totalExpenses' => $totalExpenses,
                'totalSales' => $totalSales,
                'totalBuys' => $totalBuys,
                'totalBuyProducts' => $totalBuyProducts,
                'totalSaleProducts' => $totalSalesProducts
            ],
            'pagination' => [
                'total_count' => 0,
                'total_pages' => 0,
                'current_page' => 0,
                'limit' => 0
            ]
        ]);
    }
}
