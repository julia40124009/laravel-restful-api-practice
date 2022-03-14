<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class FcmServices
{
    static function sendFcmAuth($request): array
    {
        $auth = [
            'device_type' => 'required',
            'token' => 'required',
            'title' => 'required',
            'body' => 'required',
        ];

        $tip = [
            'device_type.required' => 'token can not null. ',
            'token.required' => 'token can not null. ',
            'title.required' => 'title can not null. ',
            'body.required' => 'body can not null. ',
        ];

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
        }

        return ['status' => true];
    }
}
