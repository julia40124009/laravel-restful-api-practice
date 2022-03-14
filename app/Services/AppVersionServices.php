<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class AppVersionServices
{
    static function getVersionAuth($request)
    {
        $auth = [
            'os_type' => 'required',
            'app_name' => 'required',
        ];

        $tip = [
            'os_type.required' => 'os_type can not null. ',
            'app_name.required' => 'app_name can not null. ',
        ];

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
//            return ['status' => false, 'message' => $validator->errors()->first()];
        }

        return ['status' => true];
    }

    static function store($request)
    {
        $auth = [
            'os_type' => 'required',
            'app_name' => 'required',
            'update_status' => 'required|Integer|max:1',
            'version' => 'required',
            'store_url' => 'required',
        ];

        $tip = [
            'os_type.required' => 'os_type can not null. ',
            'app_name.required' => 'app_name can not null. ',
            'update_status.required' => 'update_status can not null. ',
            'update_status.Integer' => 'update_status value 0 or 1. ',
            'update_status.max' => 'update_status max length 1. ',
            'version.required' => 'version can not null. ',
            'store_url.required' => 'store_url can not null. ',
        ];

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
        }

        return ['status' => true];
    }

    static function update($request)
    {
        $auth = [
            'os_type' => 'required',
            'app_name' => 'required',
        ];

        $tip = [
            'os_type.required' => 'os_type can not null. ',
            'app_name.required' => 'app_name can not null. ',
        ];

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
        }

        return ['status' => true];
    }

    static function destroy($request)
    {
        $auth = [
            'os_type' => 'required',
            'app_name' => 'required',
        ];

        $tip = [
            'os_type.required' => 'os_type can not null. ',
            'app_name.required' => 'app_name can not null. ',
        ];

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
        }

        return ['status' => true];
    }
}
