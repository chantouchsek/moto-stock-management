<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Product\DeleteRequest;
use App\Http\Requests\Admin\Product\IndexRequest;
use App\Http\Requests\Admin\Product\ShowRequest;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Models\Product;
use App\Transformers\ProductTransformer;

class ProductController extends Controller
{
    /**
     * @var ProductTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * ProductController constructor.
     * @param ProductTransformer $transformer The transformer used to transform the model
     */
    public function __construct(ProductTransformer $transformer)
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

        $pagination = Product::search($request->get('q'), null, true)->paginate($this->getPagination());

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
     */
    public function store(StoreRequest $request)
    {
        $customer = new Product($request->all());

        $customer->save();

        return $this->respondCreated();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product $customer
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $customer, ShowRequest $request)
    {
        return $this->respond($this->transformer->transform($customer));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Product $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Product $customer)
    {
        $customer->update($request->all());
        $customer->save();
        return $this->respond(['data' => $customer, 'message' => 'Product updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product $customer
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Product $customer, DeleteRequest $request)
    {
        $customer->delete();
        return $this->respond(['data' => $customer, 'message' => 'Product destroyed.']);
    }
}
