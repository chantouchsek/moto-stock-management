<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Models\DeleteRequest;
use App\Http\Requests\Admin\Models\IndexRequest;
use App\Http\Requests\Admin\Models\ShowRequest;
use App\Http\Requests\Admin\Models\StoreRequest;
use App\Http\Requests\Admin\Models\UpdateRequest;
use App\Models\Models;
use App\Transformers\ModelsTransformer;
use Illuminate\Support\Facades\DB;

class ModelsController extends Controller
{
    /**
     * @var ModelsTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * ModelsController constructor.
     * @param ModelsTransformer $transformer The transformer used to transform the model
     */
    public function __construct(ModelsTransformer $transformer)
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

        $pagination = Models::search($request->get('q'), null, true)->paginate($this->getPagination());

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
        $model = new Models($request->all());
        $model->save();
        DB::commit();
        return $this->respond([
            'data' => $this->transformer->transform($model),
            'message' => 'Item created.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Models $model
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Models $model, ShowRequest $request)
    {
        return $this->respond($this->transformer->transform($model));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Models $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Models $model)
    {
        DB::beginTransaction();
        $model->update($request->all());
        $model->save();
        DB::commit();
        return $this->respond([
            'data' => $this->transformer->transform($model),
            'message' => 'Item updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Models $model
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Models $model, DeleteRequest $request)
    {
        $model->delete();
        return $this->respond([
            'data' => $this->transformer->transform($model),
            'message' => 'Item deleted.'
        ]);
    }
}
