<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\Http\Requests\Admin\Payroll\IndexRequest;
use App\Models\Payroll;
use App\Traits\Authorizable;
use App\Transformers\PayrollTransformer;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    use Authorizable;
    /**
     * @var PayrollTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * PayrollController constructor.
     * @param PayrollTransformer $transformer The transformer used to transform the model
     */
    public function __construct(PayrollTransformer $transformer)
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

        $pagination = Payroll::search($request->get('q'), null, true)->paginate($this->getPagination());

        $data = $this->transformer->transformCollection(collect($pagination->items()));

        return $this->respondWithPagination($pagination, [
            'data' => $data
        ]);
    }
}
