<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Payroll\DeleteRequest;
use App\Http\Requests\Admin\Payroll\IndexRequest;
use App\Http\Requests\Admin\Payroll\ShowRequest;
use App\Http\Requests\Admin\Payroll\StoreRequest;
use App\Http\Requests\Admin\Payroll\UpdateRequest;
use App\Models\Payroll;
use App\Models\User;
use App\Traits\Authorizable;
use App\Transformers\PayrollTransformer;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    // use Authorizable;
    /**
     * @var PayrollTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * PayrollController constructor.
     * @param PayrollTransformer $transformer The transformer used to transform the model
     */
    public function __construct(PayrollTransformer $transformer)
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

        $pagination = Payroll::search($request->get('q'), null, true)->paginate($this->getPagination());

        $data = $this->transformer->transformCollection(collect($pagination->items()));

        return $this->respondWithPagination($pagination, [
            'data' => $data
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
        $users = User::where('status', '=', 1)->get();
        $i = 0;
        foreach ($users as $user) {
            $payroll = new Payroll([
                'hours' => $request->input('hours', 0),
                'rate' => $user->rate,
                'over_time' => $request->input('over_time', 0)
            ]);
            $payroll->staff()->associate($user->id);
            $payroll->paidBy()->associate($request->user('api')->id);
            $payroll->grossPay();
            $payroll->save();
            $i++;
        }
        DB::commit();

        return $this->respondCreated();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payroll $payroll
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Payroll $payroll, ShowRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Payroll $payroll
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payroll $payroll
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Payroll $payroll, DeleteRequest $request)
    {
        //
    }
}
