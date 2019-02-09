<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $uniqueDevice = UserDevice::where('user_id', '=', $request->get('user_id'))
            ->where('player_id', '=', $request->get('player_id'))
            ->first();
        if (empty($uniqueDevice)) {
            DB::commit();
            $device = new UserDevice($request->all());
            $device->save();
            DB::commit();
            return $this->respondCreated('Device has been registered successful.');
        }
        return $this->respondCreated('Device already registered.');
    }

    /**
     * @param UserDevice $device
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(UserDevice $device, Request $request)
    {
        DB::beginTransaction();
        $device->fill($request->all());
        $device->save();
        DB::commit();
        return $this->respondCreated('Item updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $playerId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($playerId)
    {
        $device = UserDevice::where('player_id', $playerId)->first();
        DB::beginTransaction();
        if (!empty($device)) {
            $device->delete();
        }
        DB::commit();
        return $this->respondCreated('Item delete.');
    }
}
