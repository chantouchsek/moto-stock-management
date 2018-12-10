<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Supplier\DeleteRequest;
use App\Http\Requests\Admin\Supplier\IndexRequest;
use App\Http\Requests\Admin\Supplier\ShowRequest;
use App\Http\Requests\Admin\Supplier\StoreRequest;
use App\Http\Requests\Admin\Supplier\UpdateRequest;
use App\Models\Supplier;
use App\Transformers\SupplierTransformer;

class SupplierController extends Controller
{
    /**
     * @var SupplierTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * SuppliersController constructor.
     * @param SupplierTransformer $transformer The transformer used to transform the model
     */
    public function __construct(SupplierTransformer $transformer)
    {
        $this->middleware('permission:roles-list');
        $this->middleware('permission:roles-create', ['only' => ['store']]);
        $this->middleware('permission:roles-edit', ['only' => ['update']]);
        $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
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

        $pagination = Supplier::search($request->get('q'), null, true)->paginate($this->getPagination());

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
        $supplier = new Supplier($request->all());
        $supplier->save();
        return $this->respond(['data' => $supplier, 'message' => 'Item created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier $supplier
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Supplier $supplier, ShowRequest $request)
    {
        return $this->respond($this->transformer->transform($supplier));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Supplier $supplier
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Supplier $supplier)
    {
        $supplier->update($request->all());
        $supplier->save();
        return $this->respond(['data' => $supplier, 'message' => 'Item updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier $supplier
     * @param DeleteRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Supplier $supplier, DeleteRequest $request)
    {
        $supplier->delete();
        return response(['data' => $supplier, 'message' => 'Item deleted.']);
    }
}
