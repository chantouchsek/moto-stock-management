<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\DeleteRequest;
use App\Http\Requests\Admin\Role\IndexRequest;
use App\Http\Requests\Admin\Role\StoreRequest;
use App\Http\Requests\Admin\Role\UpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Traits\Authorizable;
use App\Transformers\RoleTransformer;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    use Authorizable;
    /**
     * @var RoleTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * RolesController constructor.
     * @param RoleTransformer $transformer The transformer used to transform the model
     */
    public function __construct(RoleTransformer $transformer)
    {
        $this->middleware('permission:roles-list');
        $this->middleware('permission:roles-create', ['only' => ['store']]);
        $this->middleware('permission:roles-edit', ['only' => ['update']]);
        $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
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

        $pagination = Role::search($request->get('q'), null, true)->paginate($this->getPagination());

        $users = $this->transformer->transformCollection(collect($pagination->items()));

        return $this->respondWithPagination($pagination, [
            'data' => $users
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

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return $this->respondCreated();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get();
        return $this->respond($this->transformer->transform($role));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();


        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Role $role)
    {
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return $this->respondCreated('Item updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role $role
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(Role $role, DeleteRequest $request)
    {
        //
    }
}
