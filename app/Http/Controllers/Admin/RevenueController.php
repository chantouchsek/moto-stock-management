<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Revenue\IndexRequest;
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
        if ($request->get('limit')) {
            $this->setPagination($request->get('limit'));
        }

        $year = (int)$request->input('year', Carbon::now()->format('Y'));

        $incomes = DB::table('sales')
            ->select(DB::raw('LPAD(MONTH(sales.date), 2, 0) as month, SUM(total) as total,YEAR(sales.date) as year'))
            ->whereYear('date', '=', $year)
            ->groupBy(['month'])
            ->get()->toArray();

        $current_date = [];
        $value = [];

        foreach ($incomes as $item) {
            array_push($current_date, $item->month);
            $value[$item->month] = $item;
        }

        $dataInComes = [];
        for ($m = 1; $m <= 12; $m++) {
            $time = mktime(12, 0, 0, $m, 1, $year);
            $list = date('m', $time);
            if (in_array($list, $current_date)) {
                $dataInComes[] = $value[$list];
            } else {
                array_push($dataInComes, [
                    "total" => 0,
                    'month' => date('m', $time),
                    'year' => date('Y', $time),
                ]);
            }
        }

        return $this->respond(['data' => $this->transformer->transformCollection(collect($dataInComes))]);
    }
}
