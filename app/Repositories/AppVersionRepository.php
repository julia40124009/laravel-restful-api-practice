<?php

namespace App\Repositories;

use App\Models\AppVersion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppVersionRepository extends Repository
{
    protected $AppVersionModel;

    public function __construct(AppVersion $model)
    {
        $this->AppVersionModel = $model;
    }

    public function model(): string
    {
        return 'App\Models\AppVersion';
    }

    public function getVersion(Request $request): JsonResponse
    {
        $result = [
            'status' => 'error',
            'os_type' => '',
            'app_name' => '',
            'version' => '',
            'store_url' => '',
            'update_status' => '',
        ];

        $info = $this->AppVersionModel->where([
            ['os_type', '=', $request->input('os_type')],
            ['app_name', '=', $request->input('app_name')],
        ])->first();

        if (!$info) {
            return response()->json($result, 404);
        } else {
            $result['status'] = 'success';
            $result['os_type'] = $info->os_type;
            $result['app_name'] = $info->app_name;
            $result['version'] = $info->version;
            $result['store_url'] = $info->store_url;
            $result['update_status'] = $info->update_status;
        }
        return response()->json($result);
    }

    public function createVersion(Request $request): JsonResponse
    {
        $result = [
            'status' => 'success',
            'message' => '新增成功',
        ];

        $AppVersion = $this->AppVersionModel->where([
            ['app_name', '=', $request->input('app_name')],
        ])->first();

        if ($AppVersion) {
            $result['status'] = 'error';
            $result['message'] = '已經有相同的app_name';
            return response()->json($result, 404);
        }
        $this->AppVersionModel::create($request->all());
        return response()->json($result, 200);
    }

    public function updateVersion(Request $request): JsonResponse
    {
        $result = [
            'status' => 'error',
            'message' => '更新版本資訊失敗',
        ];

        $AppVersion = $this->AppVersionModel->where([
            ['os_type', '=', $request->input('os_type')],
            ['app_name', '=', $request->input('app_name')],
        ])->get()->first();

        if ($AppVersion) {
            if ($request->input('update_status')) {
                $AppVersion->update_status = $request->input('update_status');
            }

            if ($request->input('version')) {
                $AppVersion->version = $request->input('version');
            }

            if ($request->input('store_url')) {
                $AppVersion->store_url = $request->input('store_url');
            }

            $AppVersion->save();
            $result['status'] = 'success';
            $result['message'] = '更新版本資訊成功!';
            return response()->json($result);
        } else {
            return response()->json($result, 404);
        }
    }

    public function deleteVersion(Request $request): JsonResponse
    {
        $result = [
            'status' => 'success',
            'message' => '刪除版本資訊成功!',
        ];

        $data = $this->AppVersionModel->where([
            ['os_type', '=', $request->input('os_type')],
            ['app_name', '=', $request->input('app_name')],
        ]);

        if (!$data->get()->first()) {
            $result['status'] = 'error';
            $result['message'] = '找不到要刪除的版本資訊!';
            return response()->json($result, 404);
        } else {
            $data->delete();
            return response()->json($result, 200);
        }
    }
}
