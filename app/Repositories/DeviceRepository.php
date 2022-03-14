<?php

namespace App\Repositories;

use App\Models\Device;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DeviceRepository extends Repository
{
    protected $model;

    public function __construct(Device $model)
    {
        $this->model = $model;
    }

    public function model(): string
    {
        return 'App\Models\Device';
    }

    public function getDevice(Request $request): JsonResponse
    {
        $array = array();
        $device = $this->model->where([
            ['email', '=', $request->user()->email],
        ])->get();

        foreach ($device as $value) {
            $array[] = Arr::add(['SN' => $value->sn], 'device_name', $value->device_name);
        }

        return response()->json($array);
    }

    public function checkDeviceSn(Request $request): JsonResponse
    {
        $result = [
            'document' => 'exist: 0 = 已被使用編號 1 = 可用編號',
            'exist' => '',
        ];

        $device = $this->model->where([
            ['email', '=', $request->user()->email],
            ['sn', '=', $request->input('sn')]
        ])->get();

        if (!$device->isEmpty()) {
            $result['exist'] = '0';
        } else {
            $result['exist'] = '1';
        }
        return response()->json($result);
    }

    public function insertDevice(Request $request): JsonResponse
    {
        $result = [
            'status' => 'success',
            'message' => '新增成功',
        ];

        // sn device name
        $input = [
            'sn' => $request->input('sn'),
            'email' => $request->user()->email,
            'mobilephone' => $request->user()->mobilephone,
            'device_name' => $request->input('device_name')];
        $this->model::create($input);
        return response()->json($result);
    }

    public function updateDevice(Request $request): JsonResponse
    {
        $result = [
            'status' => 'success',
            'message' => '更新成功',
        ];

        $device = $request->user()->device->where('sn', '=', $request->input('sn'))->first();
        if (!$device) {
            $result['status'] = 'error';
            $result['message'] = '更新失敗';
            return response()->json($result, 404);
        } else {
            // 更新
            $device->device_name = $request->input('device_name');
            $device->save();
            return response()->json($result);
        }
    }

    public function deleteDevice(Request $request): JsonResponse
    {
        $result = [
            'status' => 'success',
            'message' => '刪除成功',
        ];

        $device = $request->user()->device->where('sn', '=', $request->input('sn'))->first();
        if (!$device) {
            $result['status'] = 'error';
            $result['message'] = '刪除失敗，查無該設備編號!';
            return response()->json($result, 404);
        } else {
            // 刪除
            $device->delete();
            return response()->json($result);
        }
    }
}
