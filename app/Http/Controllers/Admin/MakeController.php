<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Make\DeleteRequest;
use App\Http\Requests\Admin\Make\IndexRequest;
use App\Http\Requests\Admin\Make\ShowRequest;
use App\Http\Requests\Admin\Make\StoreRequest;
use App\Http\Requests\Admin\Make\UpdateRequest;
use App\Models\Make;
use App\Transformers\MakeTransformer;
use Illuminate\Support\Facades\DB;

class MakeController extends Controller
{
    /**
     * @var MakeTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * MakeController constructor.
     * @param MakeTransformer $transformer The transformer used to transform the model
     */
    public function __construct(MakeTransformer $transformer)
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

        $pagination = Make::search($request->get('q'), null, true)->paginate($this->getPagination());

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
        $input = $request->all();
        $make = Make::create($input);
        DB::commit();
        return $this->respond([
            'data' => $this->transformer->transform($make),
            'message' => 'Item created.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Make $make
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Make $make, ShowRequest $request)
    {
        return $this->respond($this->transformer->transform($make));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Make $make
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Make $make)
    {
        DB::beginTransaction();
        $make->update($request->all());
        $make->save();
        DB::commit();
        return $this->respond([
            'data' => $this->transformer->transform($make),
            'message' => 'Item updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Make $make
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Make $make, DeleteRequest $request)
    {
        $make->delete();
        return $this->respond([
            'data' => $this->transformer->transform($make),
            'message' => 'Item deleted.'
        ]);
    }
}
