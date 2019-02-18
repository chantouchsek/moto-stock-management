<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Revenue\IndexRequest;
use App\Models\Expense;
use App\Models\Payroll;
use App\Models\Product;
use App\Models\Sale;
use App\Traits\Authorizable;
use App\Transformers\RevenueTransformer;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    use Authorizable;
    /**
     * @var RevenueTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * RevenueController constructor.
     * @param RevenueTransformer $transformer The transformer used to transform the model
     */
    public function __construct(RevenueTransformer $transformer)
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
        $year = (int)$request->input('year', Carbon::now()->format('Y'));

        $incomes = Sale::select(DB::raw('LPAD(MONTH(sales.date), 2, 0) as month, SUM(total) as total,YEAR(sales.date) as year'))
            ->whereYear('date', '=', $year)
            ->groupBy(['month'])
            ->get();

        $expenses = Expense::select(DB::raw('LPAD(MONTH(date), 2, 0) as month, SUM(amount) as total,YEAR(date) as year'))
            ->whereYear('date', '=', $year)
            ->groupBy(['month'])
            ->get();

        $products = Product::select(DB::raw('LPAD(MONTH(date_import), 2, 0) as month, SUM(cost) as total,YEAR(date_import) as year'))
            ->whereYear('date_import', '=', $year)
            ->groupBy(['month'])
            ->get();

        $payrolls = Payroll::select(DB::raw('LPAD(MONTH(created_at), 2, 0) as month, SUM(net) as total,YEAR(created_at) as year'))
            ->whereYear('created_at', '=', $year)
            ->groupBy(['month'])
            ->get();

        $currentDateIncome = [];
        $valueIncome = [];
        foreach ($incomes as $item) {
            array_push($currentDateIncome, $item['month']);
            $valueIncome[$item['month']] = $item;
        }

        $currentDateExpense = [];
        $valueExpense = [];
        foreach ($expenses as $item) {
            array_push($currentDateExpense, $item['month']);
            $valueExpense[$item['month']] = $item;
        }

        $currentDateProduct = [];
        $valueProduct = [];
        foreach ($products as $item) {
            array_push($currentDateProduct, $item['month']);
            $valueProduct[$item['month']] = $item;
        }

        $currentDatePayroll = [];
        $valuePayroll = [];
        foreach ($payrolls as $item) {
            array_push($currentDatePayroll, $item['month']);
            $valuePayroll[$item['month']] = $item;
        }

        $dataInComes = [];
        $dataProducts = [];
        $dataPayrolls = [];
        $dataOutcomes = [];
        for ($m = 1; $m <= 12; $m++) {
            $time = mktime(0, 0, 0, $m, 1, $year);
            $list = date('m', $time);

            if (in_array($list, $currentDateIncome)) {
                $dataInComes[] = $valueIncome[$list];
            } else {
                array_push($dataInComes, [
                    "total" => 0,
                    'month' => date('m', $time),
                    'year' => date('Y', $time),
                ]);
            }

            if (in_array($list, $currentDateExpense)) {
                $dataOutcomes[] = $valueExpense[$list];
            } else {
                array_push($dataOutcomes, [
                    "total" => 0,
                    'month' => date('m', $time),
                    'year' => date('Y', $time),
                ]);
            }

            if (in_array($list, $currentDateProduct)) {
                $dataProducts[] = $valueProduct[$list];
            } else {
                array_push($dataProducts, [
                    "total" => 0,
                    'month' => date('m', $time),
                    'year' => date('Y', $time),
                ]);
            }

            if (in_array($list, $currentDatePayroll)) {
                $dataPayrolls[] = $valuePayroll[$list];
            } else {
                array_push($dataPayrolls, [
                    "total" => 0,
                    'month' => date('m', $time),
                    'year' => date('Y', $time),
                ]);
            }
        }

        $sumExpense = $expenses->sum('total') + $products->sum('total') + $payrolls->sum('total');
        $totalRevenue = $incomes->sum('total') - $sumExpense;

        return $this->respond(['data' => [
            'all' => [
                number_format($sumExpense, 2), //expenses
                number_format($incomes->sum('total'), 2), // incomes
                number_format($totalRevenue, 2), // revenues
            ],
            'expenses' => $this->transformer->transformCollection(collect($dataInComes)),
            'products' => $this->transformer->transformCollection(collect($dataProducts)),
            'payrolls' => $this->transformer->transformCollection(collect($dataPayrolls)),
            'incomes' => $this->transformer->transformCollection(collect($dataInComes))
        ]]);
    }

    /**
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function productBy(IndexRequest $request)
    {
        $fromDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
        $tillDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
        $type = $request->input('type', 'model');

        $products = Product::whereBetween(DB::raw('date(date_import)'), [$fromDate, $tillDate])
            ->with(['make', 'model', 'color'])
            ->when($type === 'make', function ($query) {
                $query->orderBy('make_id');
            })
            ->when($type === 'model', function ($query) {
                $query->orderBy('model_id');
            })
            ->when($type === 'color', function ($query) {
                $query->orderBy('color_id');
            })
            ->get()->groupBy(function ($query) use ($type) {
                if ($type === 'make') {
                    return $query->make->name;
                }
                if ($type === 'model') {
                    return $query->model->name;
                }
                return $query->color->name;
            })->map(function ($row) {
                return $row->count();
            });

        $productsArray = [];

        $labels = [];

        $rgbColors = collect();

        foreach ($products as $key => $item) {
            array_push($labels, $key);
            array_push($productsArray, $item);
            $rgbColors->push($this->random_color());
        }

        return $this->respond(['data' => [
            'products' => $productsArray,
            'labels' => $labels,
            'all' => $products,
            'colors' => $rgbColors
        ]]);
    }

    /**
     * @return string
     */
    public function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function random_color()
    {
        return '#' . $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
}
