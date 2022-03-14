<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterRepository extends Repository
{
    protected $UserDataModel, $UserModel;

    public function __construct(UserData $model, User $User)
    {
        $this->UserDataModel = $model;
        $this->UserModel = $User;
    }

    public function model(): string
    {
        return 'App\Models\UserData';
    }

    public function register(Request $request): JsonResponse
    {
        $result = [
            'Register' => '0',
            'message' => '註冊失敗!',
        ];

        // 檢查帳號是否重複
        $userinfo = $this->UserModel->where([
            ['email', '=', $request->input('email')],
        ])->first();

        if ($userinfo) {
            return response()->json($result, 404);
        } else {
            $input = [
                'email' => $request->input('email'),
                'mobilephone' => $request->has('mobilephone') ? $request->input('mobilephone') : "",
                'password' => Hash::make($request->input('password'))];
            $user = $this->UserModel::create($input);
            $userData = $this->UserDataModel::create($request->all());
            if ($user && $userData) {
                $result['Register'] = '1';
                $result['message'] = '註冊成功!';
                return response()->json($result);
            } else {
                return response()->json($result, 404);
            }
        }
    }
}
