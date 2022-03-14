<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class DeviceServices
{
    static function insertDeviceAuth($request): array
    {
        $auth = [
            'sn' => 'required',
            'device_name' => 'required',
        ];

        $tip = [
            'sn.required' => 'sn can not null. ',
            'device_name.required' => 'device_name can not null. ',
        ];

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
        }

        return ['status' => true];
    }

    static function updateDeviceAuth($request): array
    {
        $auth = [
            'sn' => 'required',
            'device_name' => 'required',
        ];

        $tip = [
            'sn.required' => 'sn can not null. ',
            'device_name.required' => 'device_name can not null. ',
        ];

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
        }

        return ['status' => true];
    }

    static function deleteDeviceAuth($request): array
    {
        $auth = [
            'sn' => 'required',
        ];

        $tip = [
            'sn.required' => 'sn can not null. ',
        ];

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
        }

        return ['status' => true];
    }
}
