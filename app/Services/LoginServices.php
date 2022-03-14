<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class LoginServices
{
    static function loginAuth($request): array
    {
        $auth = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $tip = [
            'email.required' => 'email can not null. ',
            'email.email' => 'email format wrong. ',
            'password.required' => 'password can not null. ',
        ];

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
        }

        return ['status' => true];
    }

    static function registerAuth($request): array
    {
        if ($request->has('birthday')) {
            $auth = [
                'email' => 'required|email',
                'password' => 'required',
                'birthday' => 'required|date|date_format:Y-m-d',
            ];
            $tip = [
                'email.required' => 'email can not null. ',
                'email.email' => 'email format wrong. ',
                'password.required' => 'password can not null. ',
                'birthday.required' => 'birthday wrong. ',
            ];
        } else {
            $auth = [
                'email' => 'required|email',
                'password' => 'required',
            ];
            $tip = [
                'email.required' => 'email can not null. ',
                'email.email' => 'email format wrong. ',
                'password.required' => 'password can not null. ',
            ];
        }

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
        }

        return ['status' => true];
    }

    static function verificationCodeAuth($request): array
    {
        $auth = [
            'email' => 'required|email',
        ];

        $tip = [
            'email.required' => 'email can not null. ',
            'email.email' => 'email format wrong. ',
        ];

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
        }

        return ['status' => true];
    }

    static function passwordAuth($request): array
    {
        $auth = [
            'email' => 'required|email',
            'checkcode' => 'required',
            'password' => 'required',
        ];

        $tip = [
            'email.required' => 'email can not null. ',
            'email.email' => 'email format wrong. ',
            'checkcode.required' => 'checkcode can not null. ',
            'password.required' => 'newsetpasswd can not null. ',
        ];

        $validator = Validator::make($request->all(), $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
        }

        return ['status' => true];
    }
}
