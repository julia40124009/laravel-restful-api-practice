<?php

namespace App\Http\Controllers\Api;

use App\Repositories\DeviceRepository;
use App\Services\DeviceServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;

class DeviceController extends Controller
{
    protected $model, $deviceServices;

    public function __construct(DeviceRepository $repository, DeviceServices $services)
    {
        $this->model = $repository;
        $this->deviceServices = $services;
    }

    /**
     * 取得設備清單資料
     * @param Request $request
     * @return JsonResponse
     */
    public function getDevice(Request $request): JsonResponse
    {
        return $this->model->getDevice($request);
    }

    /**
     * 檢查設備編號是否已新增
     * @param Request $request
     * @return JsonResponse
     */
    public function checkDeviceSn(Request $request): JsonResponse
    {
        // 驗證參數
        $validator = $this->deviceServices::deleteDeviceAuth($request);
        if (!$validator['status']) {
            return response()->json(['status' => "error", 'message' => $validator['message']]);
        }

        return $this->model->checkDeviceSn($request);
    }


    /**
     * 新增設備
     * @param Request $request
     * @return JsonResponse
     */
    public function insertDevice(Request $request): JsonResponse
    {
        // 驗證參數
        $validator = $this->deviceServices::insertDeviceAuth($request);
        if (!$validator['status']) {
            return response()->json(['status' => "error", 'message' => $validator['message']]);
        }

        return $this->model->insertDevice($request);
    }

    /**
     * 更新設備名稱
     * @param Request $request
     * @return JsonResponse
     */
    public function updateDevice(Request $request): JsonResponse
    {
        // 驗證參數
        $validator = $this->deviceServices::updateDeviceAuth($request);
        if (!$validator['status']) {
            return response()->json(['status' => "error", 'message' => $validator['message']]);
        }

        return $this->model->updateDevice($request);
    }

    /**
     * 刪除設備
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteDevice(Request $request): JsonResponse
    {
        // 驗證參數
        $validator = $this->deviceServices::deleteDeviceAuth($request);
        if (!$validator['status']) {
            return response()->json(['status' => "error", 'message' => $validator['message']]);
        }

        return $this->model->deleteDevice($request);
    }

}
