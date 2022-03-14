<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginRepository extends Repository
{
    protected $UserModel;

    public function __construct(User $model)
    {
        $this->UserModel = $model;
    }

    public function model(): string
    {
        return 'App\Models\User';
    }

    public function getLoginResult(Request $request): JsonResponse
    {
        $result = [
            'Login' => '0',
            'Email' => '',
            'MobilePhoneTemp' => '',
            'Devices' => [],    // 該帳號底下裝置清單
            'data' => '',
        ];

//        $credentials = $request->only('email', 'password');
//        if (Auth::attempt($credentials)) {
//            var_dump('密碼驗證成功');
//        } else {
//            var_dump('else');
//        }

        $userinfo = $this->UserModel->where([
            ['email', '=', $request->input('email')],
        ])->first();    // ->with('device') 是讓你大量查的時候用的，只有一人的設備資料不需要

        if (!$userinfo) {
            return response()->json($result, 404);
        } else {
            if (Hash::check($request->input('password'), $userinfo->password)) {
                $result['Login'] = '1';
                $result['Email'] = $userinfo->email;
                $result['MobilePhoneTemp'] = $userinfo->mobilephone;
                $result['Devices'] = $userinfo->Device;
                $result['data'] = $userinfo->UserData;
                return response()->json($result);
            } else {
                return response()->json($result, 404);
            }
        }
    }

    /** 上傳檔案
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadFile(Request $request): JsonResponse
    {
        $result = [
            'status' => 'error',
        ];

        if (!$request->hasFile('profile')) {
            $result['message'] = 'upload file not found';
            return response()->json($result, 400);
        }

        $allowedFileExtension = ['pdf', 'jpg', 'jpeg', 'png'];
        $files = $request->file('profile');
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $allowedFileExtension);
            if ($check) {
                foreach ($request->file('profile') as $mediaFiles) {
                    // TODO 存檔案
                    $path = $mediaFiles->storeAs('public/images', 'wtf.jpg');
                    // TODO 原始檔名
                    $name = $mediaFiles->getClientOriginalName();
                    // TODO store image file db
//                    $save = new Image();
//                    $save->title = $name;
//                    $save->path = $path;
//                    $save->save();
                }
            } else {
                $result['message'] = 'invalid file format';
                return response()->json($result, 422);
            }
            $result['status'] = 'success';
            return response()->json($result);
        }
        return response()->json($result, 404);
    }
}
