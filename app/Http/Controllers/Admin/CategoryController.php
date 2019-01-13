<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Category\DeleteRequest;
use App\Http\Requests\Admin\Category\IndexRequest;
use App\Http\Requests\Admin\Category\ShowRequest;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Transformers\CategoryTransformer;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    /**
     * @var CategoryTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * CategoryController constructor.
     * @param CategoryTransformer $transformer The transformer used to transform the model
     */
    public function __construct(CategoryTransformer $transformer)
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

        $pagination = Category::search($request->get('q'), null, true)->paginate($this->getPagination());

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
     * @throws \Exception
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $category = new Category($request->all());

        $category->save();
        DB::commit();
        return $this->respondCreated();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category $category
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category, ShowRequest $request)
    {
        return $this->respond($this->transformer->transform($category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(UpdateRequest $request, Category $category)
    {
        DB::beginTransaction();
        $category->update($request->all());
        $category->save();
        DB::commit();
        return $this->respond(['data' => $category, 'message' => 'Category updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category $category
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category, DeleteRequest $request)
    {
        $category->delete();
        return $this->respond(['data' => $category, 'message' => 'Category destroyed.']);
    }
}
