<?php

namespace App\Http\Controllers\Api;

use App\Repositories\AppVersionRepository;
use App\Services\AppVersionServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;

class AppVersionController extends Controller
{
    protected $app_version, $appVersionServices;

    public function __construct(AppVersionRepository $repository, AppVersionServices $services)
    {
        $this->app_version = $repository;
        $this->appVersionServices = $services;
    }

    /**
     * 取得APP版本號
     */
    public function getVersion(Request $request): JsonResponse
    {
        // 驗證參數
        $validator = $this->appVersionServices::getVersionAuth($request);
        if (!$validator['status']) {
            return response()->json(['status' => "error", 'message' => $validator['message']]);
        }

        return $this->app_version->getVersion($request);
    }

    /**
     * 新增APP版本號
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        // 驗證參數
        $validator = $this->appVersionServices::store($request);
        if (!$validator['status']) {
            return response()->json(['status' => "error", 'message' => $validator['message']]);
        }
        return $this->app_version->createVersion($request);
    }

    /**
     * 更新APP版本號資訊
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        // 驗證參數
        $validator = $this->appVersionServices::update($request);
        if (!$validator['status']) {
            return response()->json(['status' => "error", 'message' => $validator['message']]);
        }
        return $this->app_version->updateVersion($request);
    }

    /**
     * 刪除APP版本號資訊
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        // 驗證參數
        $validator = $this->appVersionServices::destroy($request);
        if (!$validator['status']) {
            return response()->json(['status' => "error", 'message' => $validator['message']]);
        }
        return $this->app_version->deleteVersion($request);
    }
}
