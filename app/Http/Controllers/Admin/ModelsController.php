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
        $model = new Models($request->all());
        $model->save();
        return $this->respond(['data' => $model, 'message' => 'Item created.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Models $models
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Models $models, ShowRequest $request)
    {
        return $this->respond($this->transformer->transform($models));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Models $models
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Models $models)
    {
        $models->update($request->all());
        $models->save();
        return $this->respond(['data' => $models, 'message' => 'Item updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Models $models
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Models $models, DeleteRequest $request)
    {
        $models->delete();
        return $this->respond(['data' => $models, 'message' => 'Item deleted.']);
    }
}
