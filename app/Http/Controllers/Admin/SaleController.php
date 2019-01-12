<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Transformers\SaleTransformer;
use App\Http\Requests\Admin\Sale\DeleteRequest;
use App\Http\Requests\Admin\Sale\IndexRequest;
use App\Http\Requests\Admin\Sale\ShowRequest;
use App\Http\Requests\Admin\Sale\StoreRequest;
use App\Http\Requests\Admin\Sale\UpdateRequest;

class SaleController extends Controller
{

    /**
     * @var SaleTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * SaleController constructor.
     * @param SaleTransformer $transformer The transformer used to transform the model
     */
    public function __construct(SaleTransformer $transformer)
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

        $pagination = Sale::search($request->get('q'), null, true)->paginate($this->getPagination());

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
        DB::beginTransaction();

        $sale = new Sale($request->all());
        $sale->user()->associate($request->user()->id);
        $sale->save();

        $sale->product()->update(['sole_on' => Carbon::now()]);

        if ($request->hasFile('files')) {
            $sale->addMultipleMediaFromRequest(['files'])->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('sale-attachment');
            });
        }

        DB::commit();

        return $this->respond(['data' => $this->transformer->transform($sale), 'message' => 'Sale created.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale $sale
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Sale $sale, ShowRequest $request)
    {
        return $this->respond($this->transformer->transform($sale));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Sale $sale
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Sale $sale)
    {
        DB::beginTransaction();

        $sale->update($request->except(['product_id', 'engine_number', 'plate_number']));

        DB::commit();

        return $this->respond(['data' => $this->transformer->transform($sale), 'message' => 'Sale updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale $sale
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Sale $sale, DeleteRequest $request)
    {
        $sale->delete();
        return $this->respond(['data' => $this->transformer->transform($sale), 'message' => 'Sale deleted.']);
    }
}
