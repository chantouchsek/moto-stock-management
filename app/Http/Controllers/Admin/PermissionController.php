<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Permission\IndexRequest;
use App\Http\Requests\Admin\Permission\StoreRequest;
use App\Http\Requests\Admin\Permission\UpdateRequest;
use App\Models\Permission;
use App\Traits\Authorizable;
use App\Transformers\PermissionTransformer;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    use Authorizable;
    /**
     * @var PermissionTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * PermissionsController constructor.
     * @param PermissionTransformer $transformer The transformer used to transform the model
     */
    public function __construct(PermissionTransformer $transformer)
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

        $pagination = Permission::search($request->get('q'), null, true)->paginate($this->getPagination());

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
        $permission = new Permission($request->input('name'));
        $permission->save();
        return $this->respond(['data' => $permission, 'Permission created']);
    }

    /**
     * Display the specified resource.
     *
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Permission $permission)
    {
        return $this->respond($this->transformer->transform($permission));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Permission $permission)
    {
        $permission->name = $request->input('name');
        $permission->save();
        return $this->respond(['data' => $permission, 'Permission updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
