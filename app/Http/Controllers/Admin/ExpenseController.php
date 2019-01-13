<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Expense\DeleteRequest;
use App\Http\Requests\Admin\Expense\IndexRequest;
use App\Http\Requests\Admin\Expense\ShowRequest;
use App\Http\Requests\Admin\Expense\StoreRequest;
use App\Http\Requests\Admin\Expense\UpdateRequest;
use App\Models\Expense;
use App\Transformers\ExpenseTransformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * @var ExpenseTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * ExpenseController constructor.
     * @param ExpenseTransformer $transformer The transformer used to transform the model
     */
    public function __construct(ExpenseTransformer $transformer)
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

        $pagination = Expense::search($request->get('q'), null, true)
            ->orderBy('date')
            ->paginate($this->getPagination());

        $data = $this->transformer->transformCollection(collect($pagination->items()));

        $monthlyExpenses = $data->groupBy(function ($item) {
            return Carbon::createFromFormat('Y-m-d', $item['date'])->format('Y-m');
        })->map(function ($row) {
            return [
                'total' => number_format($row->sum->amount, 2),
                'expenses' => $row->map(function ($item) {
                    return [
                        'amount' => number_format($item['amount'], 2),
                        'date' => $item['date'],
                        'expense_on' => $item['expense_on'],
                        'notes' => $item['notes'],
                        'user' => $item['user'],
                        'user_id' => $item['user_id'],
                        'uuid' => $item['uuid'],
                        'id' => $item['id']
                    ];
                })
            ];
        });

        return $this->respondWithPagination($pagination, [
            'data' => $monthlyExpenses
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $input = $request->all();
        $input['user_id'] = $request->user('api')->id;
        $expense = Expense::create($input);
        DB::commit();
        return $this->respond([
            'data' => $this->transformer->transform($expense),
            'message' => 'Item created.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense $expense
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Expense $expense, ShowRequest $request)
    {
        return $this->respond($this->transformer->transform($expense));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Expense $expense
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(UpdateRequest $request, Expense $expense)
    {
        DB::beginTransaction();
        $expense->update($request->all());
        $expense->save();
        DB::commit();
        return $this->respond([
            'data' => $this->transformer->transform($expense),
            'message' => 'Item updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense $expense
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Expense $expense, DeleteRequest $request)
    {
        $expense->delete();
        return $this->respond([
            'data' => $this->transformer->transform($expense),
            'message' => 'Item deleted.'
        ]);
    }
}
