<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Report\IndexRequest;
use App\Models\Expense;
use App\Models\Payroll;
use App\Models\Product;
use App\Models\Sale;
use App\Traits\Authorizable;
use App\Transformers\ReportTransformer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    use Authorizable;
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
        $query = (int)$request->input('q');

        $fromDate = $request->has('q') ? Carbon::now()->addDay(-$query)->toDateString() : Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
        $tillDate = $request->has('q') ? Carbon::now()->subDay()->toDateString() : Carbon::createFromFormat('Y-m-d', $request->input('end_date'));

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

        $payrolls = Payroll::select(DB::raw('LPAD(MONTH(created_at), 2, 0) as month, SUM(net) as total,YEAR(created_at) as year'))
            ->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])
            ->groupBy(['month'])
            ->get();

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

        $dataPayroll = collect($payrolls)->groupBy(function ($pay) {
            return $pay->year;
        })->map(function ($year) {
            return number_format($year->sum('total'), 2);
        });

        $sumExpense = $expenses->sum('total') + $products->sum('cost') + $payrolls->sum('total');
        $totalRevenue = $sales->sum('total') - $sumExpense;

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
                'totalSaleProducts' => $totalSalesProducts,
                'totalRevenue' => number_format($totalRevenue, 2),
                'payrolls' => $dataPayroll,
                'totalPayroll' => number_format($payrolls->sum('total'), 2)
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
