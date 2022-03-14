<?php

namespace App\Http\Controllers\Api;

use App\Services\FcmServices;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;

class FcmController extends Controller
{
    protected $fcmServices;

    public function __construct(FcmServices $services)
    {
        $this->fcmServices = $services;
    }

    public function store(Request $request)
    {
        // 驗證參數
        $validator = $this->fcmServices::sendFcmAuth($request);
        if (!$validator['status']) {
            return response()->json(['status' => "error", 'message' => $validator['message']]);
        }

        // 裝置OS
        $deviceType = $request->input('device_type');

        // 使用者token
        $registrationIds = $request->input('token');

        // key
        $API_ACCESS_KEY = 'FCM TOKEN KEY';

        $msg = array
        (
            'title' => $request->input('title'),
            'body' => $request->input('body'),
//            "click_action" => "REGISTER.FINISH",    // 推播點擊跳頁關鍵字
            'icon' => 'myicon',/*Default Icon*/
            'sound' => 'mySound'/*Default sound*/
        );

        $data = array(
            'key' => 'value',
            'is_show' => '1',
        );

        $fields = array
        (
            'to' => $registrationIds,
            // 靜音推播不帶入 notification key
            'notification' => $msg,
//            'content_available' => true,
            'data' => $data
        );

        $headers = array
        (
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($result, true);
        // echo json_encode($obj);
        if ($obj["success"] == "1") {
            return response()->json([
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
            ]);
        }
    }
}
