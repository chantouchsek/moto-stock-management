<?php

namespace App\Http\Controllers\Admin\Expense;

use App\Http\Requests\Admin\Expense\IndexRequest;
use App\Models\Expense;
use App\Traits\Authorizable;
use App\Transformers\RevisionTransformer;
use App\Http\Controllers\Controller;

class RevisionController extends Controller
{
    use Authorizable;

    /**
     * @var RevisionTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * ExpenseController constructor.
     * @param RevisionTransformer $transformer The transformer used to transform the model
     */
    public function __construct(RevisionTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @param Expense $expense
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request, Expense $expense)
    {
        if ($request->get('limit')) {
            $this->setPagination($request->get('limit'));
        }

        $pagination = $expense->revisionHistory()->paginate($this->getPagination());

        $data = $this->transformer->transformCollection(collect($pagination->items()));

        return $this->respondWithPagination($pagination, [
            'data' => $data
        ]);
    }
}
