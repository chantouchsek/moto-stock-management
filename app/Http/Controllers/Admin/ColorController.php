<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Color\DeleteRequest;
use App\Http\Requests\Admin\Color\IndexRequest;
use App\Http\Requests\Admin\Color\ShowRequest;
use App\Http\Requests\Admin\Color\StoreRequest;
use App\Http\Requests\Admin\Color\UpdateRequest;
use App\Models\Color;
use App\Transformers\ColorTransformer;

class ColorController extends Controller
{
    /**
     * @var ColorTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * ColorController constructor.
     * @param ColorTransformer $transformer The transformer used to transform the model
     */
    public function __construct(ColorTransformer $transformer)
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

        $pagination = Color::search($request->get('q'), null, true)->paginate($this->getPagination());

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
        $color = new Color($request->all());

        $color->save();

        return $this->respondCreated();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Color $color
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Color $color, ShowRequest $request)
    {
        return $this->respond($this->transformer->transform($color));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Color $color
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Color $color)
    {
        $color->update($request->all());
        $color->save();
        return $this->respond(['data' => $color, 'message' => 'Color updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Color $color
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Color $color, DeleteRequest $request)
    {
        $color->delete();
        return $this->respond(['data' => $color, 'message' => 'Color destroyed.']);
    }
}
