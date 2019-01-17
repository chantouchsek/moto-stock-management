<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Payroll\DeleteRequest;
use App\Http\Requests\Admin\Payroll\IndexRequest;
use App\Http\Requests\Admin\Payroll\ShowRequest;
use App\Http\Requests\Admin\Payroll\StoreRequest;
use App\Http\Requests\Admin\Payroll\UpdateRequest;
use App\Models\Loan;
use App\Models\Payroll;
use App\Models\User;
use App\Traits\Authorizable;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    // use Authorizable;
    /**
     * @var UserTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * UserController constructor.
     * @param UserTransformer $transformer The transformer used to transform the model
     */
    public function __construct(UserTransformer $transformer)
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

        $pagination = User::search($request->get('q'), null, true)
            ->with(['loans' => function ($query) {
                $query->where('is_approved', 1)->where('is_paid_back', 0);
            }])
            ->role(['Admin', 'User'])
            ->where('status', '=', 1)
            ->paginate($this->getPagination());

        $data = $this->transformer->transformCollection(collect($pagination->items()));

        $payRolls = $data->map(function ($rows) {
            $total_loan = count($rows['loans']);
            return [
                'id' => $rows['id'],
                'uuid' => $rows['uuid'],
                'full_name' => $rows['full_name'],
                'total_loan' => $total_loan ? number_format($rows['loans']->sum->amount, 2) : 0,
                'basic' => number_format($rows['base_salary'], 2),
                'avatar_url' => $rows['avatar_url'],
                'net' => $total_loan ? number_format($rows['base_salary'] - $rows['loans']->sum->amount, 2) : number_format($rows['base_salary'], 2)
            ];
        });

        return $this->respondWithPagination($pagination, [
            'data' => $payRolls
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

        $users = User::search($request->get('q'), null, true)
            ->with(['loans' => function ($query) {
                $query->where('is_approved', 1)->where('is_paid_back', 0);
            }])
            ->role(['Admin', 'User'])
            ->where('status', '=', 1)
            ->get();

        $data = $this->transformer->transformCollection(collect($users));

        $payRolls = $data->map(function ($rows) {
            $total_loan = count($rows['loans']);
            return [
                'id' => $rows['id'],
                'uuid' => $rows['uuid'],
                'full_name' => $rows['full_name'],
                'total_loan' => $total_loan ? number_format($rows['loans']->sum->amount, 2) : 0,
                'basic' => number_format($rows['base_salary'], 2),
                'avatar_url' => $rows['avatar_url'],
                'rate' => $rows['rate'],
                'net' => $total_loan ? number_format($rows['base_salary'] - $rows['loans']->sum->amount, 2) : number_format($rows['base_salary'], 2)
            ];
        });

        $i = 0;
        foreach ($payRolls as $user) {
            $payroll = new Payroll([
                'hours' => $request->input('hours', 0),
                'rate' => $user['rate'],
                'over_time' => $request->input('over_time', 0)
            ]);
            $payroll->staff()->associate($user['id']);
            $payroll->paidBy()->associate($request->user('api')->id);
            $payroll->deducted = $user['total_loan'];
            $payroll->gross = $user['net'];
            $payroll->grossPay($user);
            $payroll->save();
            Loan::where('staff_id', $user['id'])
                ->where('is_approved', 1)
                ->where('is_paid_back', 0)
                ->update(['is_paid_back' => 1]);
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
