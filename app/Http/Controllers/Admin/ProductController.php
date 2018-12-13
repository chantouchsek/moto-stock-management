<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\DeleteRequest;
use App\Http\Requests\Admin\Product\IndexRequest;
use App\Http\Requests\Admin\Product\ShowRequest;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Models\Product;
use App\Transformers\ProductTransformer;
use Illuminate\Support\Facades\DB;

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
        $product = new Product($request->all());

        $product->save();

        return $this->respond([
            'data' => $this->transformer->transform($product),
            'message' => 'Product created.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product $product
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product, ShowRequest $request)
    {
        return $this->respond($this->transformer->transform($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Product $product)
    {
        DB::beginTransaction();

        $product->update($request->all());

        $array = [];
        $colors = collect($request->get('colors'));
        foreach ($colors as $key => $color) {
            $array[$color['colorId']] = [
                'engine_number' => $color['engineNumber'],
                'plate_number' => $color['plateNumber'],
                'frame_number' => $color['frameNumber'],
                'code' => $color['code'],
            ];
        }

        $product->colors()->sync($array);
        $product->save();

        DB::commit();
        return $this->respond([
            'data' => $this->transformer->transform($product),
            'message' => 'Product updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product $product
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Product $product, DeleteRequest $request)
    {
        $product->delete();
        return $this->respond([
            'data' => $this->transformer->transform($product),
            'message' => 'Product destroyed.'
        ]);
    }
}
