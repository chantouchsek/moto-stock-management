<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Requests\Admin\Media\DeleteRequest;
use App\Http\Requests\Admin\Media\StoreRequest;
use App\Models\Sale;
use App\Traits\MediaTrait;
use App\Transformers\SaleTransformer;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller
{
    use MediaTrait;

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
     * @param StoreRequest $request
     * @param Sale $sale
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request, Sale $sale)
    {
        return $this->upload($request, $sale, 'sale-attachment');
    }

    /**
     * @param Sale $sale
     * @param DeleteRequest $request
     * @param Media $upload
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Sale $sale, DeleteRequest $request, Media $upload)
    {
        return $this->delete($sale, $request, $upload, 'sale-attachment');
    }
}
