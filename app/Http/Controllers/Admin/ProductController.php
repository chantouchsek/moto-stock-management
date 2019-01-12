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

        $q = $request->get('q');
        $categoryId = $request->get('category_id');

        $pagination = Product::search($q, null, false)
            ->when($categoryId, function ($query, $q) {
                return $query->where('category_id', $q);
            })
            ->when($request->get('make_id'), function ($query, $q) {
                return $query->where('make_id', $q);
            })
            ->when($request->get('model_id'), function ($query, $q) {
                return $query->where('model_id', $q);
            });

        if ($request->has('first')) {
            $pagination = $pagination->first();

            if (!$pagination) {
                return $this->respond([
                    'data' => $pagination,
                    'pagination' => [
                        'total_count' => 0,
                        'total_pages' => 0,
                        'current_page' => 0,
                        'limit' => 0,
                    ],
                    "first" => true
                ]);
            }

            $data = $this->transformer->transform($pagination);

            return $this->respond([
                'data' => $data,
                'pagination' => [
                    'total_count' => 0,
                    'total_pages' => 0,
                    'current_page' => 0,
                    'limit' => 0,
                ],
                "first" => true
            ]);
        }

        $pagination = $pagination->paginate($this->getPagination());

        $data = $this->transformer->transformCollection(collect($pagination->items()));

        return $this->respondWithPagination($pagination, ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\InvalidBase64Data
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $product = new Product($request->all());

        $product->save();

        $allowedMimeTypes = ['image/jpeg', 'image/pipeg', 'image/gif'];

        if ($request->input('file')) {
            $product->addMediaFromBase64($request->get('file'), $allowedMimeTypes)
                ->toMediaCollection('product-image-featured');
        }

        DB::commit();
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
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findBy(ShowRequest $request)
    {
        $product = Product::whereEngineNumber($request->input('q'))->whereNull('sole_on')->first();
        if (!$product) {
            return $this->respond([
                'data' => $product,
                'pagination' => [
                    'total_count' => 0,
                    'total_pages' => 0,
                    'current_page' => 0,
                    'limit' => 0,
                ],
                "first" => true
            ]);
        }
        return $this->respond($this->transformer->transform($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\InvalidBase64Data
     */
    public function update(UpdateRequest $request, Product $product)
    {
        DB::beginTransaction();

        $product->update($request->all());

        $product->save();

        $allowedMimeTypes = ['image/jpeg', 'image/pipeg', 'image/gif'];

        if ($request->input('file')) {
            if ($product->hasMedia('product-image-featured')) {
                $product->clearMediaCollection('product-image-featured');
            }
            $product->addMediaFromBase64($request->get('file'), $allowedMimeTypes)
                ->toMediaCollection('product-image-featured');
        }

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
