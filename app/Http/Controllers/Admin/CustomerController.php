<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\DeleteRequest;
use App\Http\Requests\Admin\Customer\IndexRequest;
use App\Http\Requests\Admin\Customer\ShowRequest;
use App\Http\Requests\Admin\Customer\StoreRequest;
use App\Http\Requests\Admin\Customer\UpdateRequest;
use App\Models\Customer;
use App\Traits\Authorizable;
use App\Transformers\CustomerTransformer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    use Authorizable;
    /**
     * @var CustomerTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * CustomerController constructor.
     * @param CustomerTransformer $transformer The transformer used to transform the model
     */
    public function __construct(CustomerTransformer $transformer)
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

        $pagination = Customer::search($request->get('q'), null, true)
            ->with(['purchases.product'])
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
        $customer = new Customer($request->all());

        $customer->save();
        DB::commit();
        return $this->respondCreated();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer $customer
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Customer $customer, ShowRequest $request)
    {
        return $this->respond($this->transformer->transform($customer));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Customer $customer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(UpdateRequest $request, Customer $customer)
    {
        DB::beginTransaction();
        $customer->update($request->all());
        $customer->save();
        DB::commit();
        return $this->respond(['data' => $customer, 'message' => 'Customer updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer $customer
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Customer $customer, DeleteRequest $request)
    {
        $customer->delete();
        return $this->respond(['data' => $customer, 'message' => 'Customer destroyed.']);
    }
}
