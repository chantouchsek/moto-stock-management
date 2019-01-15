<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Loan\IndexRequest;
use App\Http\Requests\Admin\Loan\StoreRequest;
use App\Http\Requests\Admin\Loan\UpdateRequest;
use App\Models\Loan;
use App\Transformers\LoanTransformer;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * @var LoanTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * LoanController constructor.
     * @param LoanTransformer $transformer The transformer used to transform the model
     */
    public function __construct(LoanTransformer $transformer)
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

        $pagination = Loan::search($request->get('q'), null, true)
            ->with(['staff', 'approvedBy'])
            ->paginate($this->getPagination());

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
        $loan = new Loan($request->all());
        $loan->staff()->associate($request->user('api')->id);
        $loan->save();
        return $this->respond([
            'data' => $this->transformer->transform($loan),
            'message' => 'Item created.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan $loan
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Loan $loan)
    {
        return $this->respond($this->transformer->transform($loan));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Loan $loan
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(UpdateRequest $request, Loan $loan)
    {
        DB::beginTransaction();
        $loan->fill($request->all());
        $loan->approvedBy()->associate($request->user('api')->id);
        $loan->save();
        DB::commit();
        return $this->respond([
            'data' => $this->transformer->transform($loan),
            'message' => 'Item updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
