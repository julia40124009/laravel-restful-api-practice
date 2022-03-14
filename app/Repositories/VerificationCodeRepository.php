<?php

namespace App\Repositories;

use App\Jobs\SendEmail;
use App\Models\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\Exception;

class VerificationCodeRepository extends Repository
{
    protected $UserModel;

    public function __construct(User $User)
    {
        $this->UserModel = $User;
    }

    public function model(): string
    {
        return 'App\Models\User';
    }

    public function sendVerificationCode(Request $request): JsonResponse
    {
        $result = [
            'EmailCheck' => '0',
            'SendPasswordMail' => '0',
        ];

        // 檢查 email是否存在
        $userinfo = $this->UserModel->where([
            ['email', '=', $request->input('email')],
        ])->first();

        if ($userinfo) {
            try {
                $result['EmailCheck'] = '1';
                $result['SendPasswordMail'] = '1';
                $job = new SendEmail($request, $this->UserModel);
                dispatch($job);
                return response()->json($result);
            } catch (Exception $e) {
                $result['EmailCheck'] = '1';
                return response()->json($result, 404);
            }
        } else {
            return response()->json($result, 404);
        }
    }

    public function setPassword(Request $request): JsonResponse
    {
        $result = [
            'CheckCode' => '0',
        ];

        $userinfo = $this->UserModel->where([
            ['email', '=', $request->input('email')],
        ])->first();

        # 驗證碼比對
        if ($userinfo && $userinfo->repassword == $request->input('checkcode')) {
            $result['CheckCode'] = '1';
            // 更新密碼
            $userinfo->password = Hash::make($request->input('password'));
            // 驗證碼還原預設
            $userinfo->repassword = '$#Bg88@!';
            $userinfo->save();
            return response()->json($result);
        } else {
            return response()->json($result, 404);
        }
    }

    public function checkEmail(Request $request): JsonResponse
    {
        $result = [
            'Email Check' => '0',
        ];

        $userinfo = $this->UserModel->where([
            ['email', '=', $request->input('email')],
        ])->first();

        # 如果沒有註冊過信箱
        if (!$userinfo) {
            $result['Email Check'] = '1';
        }
        return response()->json($result);
    }
}
