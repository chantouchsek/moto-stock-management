<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\User\DeleteRequest;
use App\Http\Requests\Admin\User\IndexRequest;
use App\Http\Requests\Admin\User\ShowRequest;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Models\User;
use App\Models\Role;
use App\Transformers\UserTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * @var UserTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * RolesController constructor.
     * @param UserTransformer $transformer The transformer used to transform the model
     */
    public function __construct(UserTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request, User $user)
    {
        if ($request->get('limit')) {
            $this->setPagination($request->get('limit'));
        }

        $pagination = $user->search($request->get('q'), null, true)->paginate($this->getPagination());

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

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return $this->respondCreated('User Created');
    }


    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param ShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user, ShowRequest $request)
    {
        return $this->respond($this->transformer->transform($user));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, User $user)
    {
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }
        $user->update($input);
        $user->syncRoles($request->input('roles'));
        return $this->respond(['data' => $this->transformer->transform($user), 'message' => 'User updated.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user, DeleteRequest $request)
    {
        $user->delete();
        return $this->respond(['data' => $user, 'message' => 'User Deleted.']);
    }
}
