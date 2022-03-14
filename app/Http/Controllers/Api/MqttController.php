<?php

namespace App\Http\Controllers\Api;

use App\Models\Device;
use App\Services\DeviceServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Support\Facades\Validator;

class MqttController extends Controller
{
    protected $deviceServices, $model;

    public function __construct(DeviceServices $services, Device $model)
    {
        $this->deviceServices = $services;
        $this->model = $model;
    }

    /**
     * 檢查設備編號是否已新增
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMqtt(Request $request): JsonResponse
    {
        // 驗證參數
        $auth = [
            'sn' => 'required',
        ];

        $tip = [
            'sn.required' => 'sn can not null. ',
        ];

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return response()->json(['error']);
        }

        $sn = $this->model->where([
            ['sn', '=', $request->input('sn')]
        ])->first();

        //if ($sn) {
            $url = "http://mqtt.bgreen.com.tw:32666/api/v4/mqtt/publish";
            $username="bgreenaiot";
            $password="MzAyODE3NzQ2MTI1ODAwNjMzNzgyNzE1NDMyNTIyODc0ODI";
            $SNTemp="\"bgreen/bg3/".$request->input('sn')."\"";
            $cmd="{\"topic\":".$SNTemp.",\"payload\":\"Alan Test OK\",\"qos\":1,\"retain\":false,\"clientid\":\"example\"}";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_POST,true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$cmd );
            curl_setopt($ch, CURLOPT_USERPWD,$username.":".$password);
            $result = curl_exec($ch);
            return response()->json($result);
//        } else {
//            return response()->json(['error no sn']);
//        }
    }
}
