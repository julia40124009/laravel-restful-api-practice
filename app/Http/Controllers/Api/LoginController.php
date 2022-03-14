<?php

namespace App\Http\Controllers\Api;

use App\Repositories\LoginRepository;
use App\Repositories\RegisterRepository;
use App\Repositories\VerificationCodeRepository;
use App\Services\LoginServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController
{
    protected $loginRepository, $loginServices;
    protected $registerRepository, $verificationCodeRepository;

    public function __construct(LoginRepository            $repository, LoginServices $services, RegisterRepository $RegisterRepository,
                                VerificationCodeRepository $VerificationCodeRepository)
    {
        $this->loginRepository = $repository;
        $this->loginServices = $services;
        $this->registerRepository = $RegisterRepository;
        $this->verificationCodeRepository = $VerificationCodeRepository;
    }

    /**
     * 登入
     */
    public function login(Request $request): JsonResponse
    {
        // 驗證參數
        $validator = $this->loginServices::loginAuth($request);
        if (!$validator['status']) {
            return response()->json(['Login' => "0", 'Email' => '', 'MobilePhoneTemp' => '', 'Devices' => []]);
        }

        // 取得使用者資料
        return $this->loginRepository->getLoginResult($request);
    }

    /**
     * 註冊
     */
    public function register(Request $request): JsonResponse
    {
        // 驗證參數
        $validator = $this->loginServices::registerAuth($request);
        if (!$validator['status']) {
            return response()->json(['Register' => "0"]);
        }

        // 註冊使用者
        return $this->registerRepository->register($request);
    }

    /**
     * 忘記密碼-發送修改密碼驗證碼
     */
    public function sendVerificationCode(Request $request): JsonResponse
    {
        // 驗證參數
        $validator = $this->loginServices::verificationCodeAuth($request);
        if (!$validator['status']) {
            return response()->json(['EmailCheck' => "0", 'SendPasswordMail' => "0"]);
        }

        // 註冊使用者
        return $this->verificationCodeRepository->sendVerificationCode($request);
    }

    /**
     * 忘記密碼-輸入驗證碼
     */
    public function newPassword(Request $request): JsonResponse
    {
        // 驗證參數
        $validator = $this->loginServices::passwordAuth($request);
        if (!$validator['status']) {
            return response()->json(['CheckCode' => "0"]);
        }

        // 註冊使用者
        return $this->verificationCodeRepository->setPassword($request);
    }

    /**信箱重複確認
     * @param Request $request
     * @return JsonResponse
     */
    public function checkEmail(Request $request): JsonResponse
    {
        // 驗證參數
        $validator = $this->loginServices::verificationCodeAuth($request);
        if (!$validator['status']) {
            return response()->json(['Email Check' => "0"]);
            // 'message' => $validator->errors()
        }

        // 註冊使用者
        return $this->verificationCodeRepository->checkEmail($request);
    }
}
