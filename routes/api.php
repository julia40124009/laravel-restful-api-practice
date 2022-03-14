<?php

use App\Http\Controllers\Api\AppVersionController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\FcmController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\MqttController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

# APP 版本號
Route::get('bgreen_iot/get-version', [AppVersionController::class, 'getVersion']);
Route::put('bgreen_iot/update', [AppVersionController::class, 'update']);
Route::post('bgreen_iot/insert', [AppVersionController::class, 'store']);
Route::delete('bgreen_iot/delete', [AppVersionController::class, 'destroy']);

# 推播
Route::post('bgreen_iot/fcm', [FcmController::class, 'store']);

# 登入
Route::post('bgreen_iot/login', [LoginController::class, 'login']);
# 註冊
Route::post('bgreen_iot/register', [LoginController::class, 'register']);
# 忘記密碼-發送驗證碼
Route::post('bgreen_iot/sendVerificationCode', [LoginController::class, 'sendVerificationCode']);
# 忘記密碼-輸入驗證碼
Route::post('bgreen_iot/newPassword', [LoginController::class, 'newPassword']);
# 信箱重複確認
Route::post('bgreen_iot/checkEmail', [LoginController::class, 'checkEmail']);

# Route::post('oauth/token', [AccessTokenController::class, 'issueToken']);

Route::middleware(['auth:api'])->group(function () {
    # Route::get('bgreen_iot/get-version', [AppVersionController::class, 'getVersion']);
    # 設備相關
    Route::get('bgreen_iot/check-device', [DeviceController::class, 'checkDeviceSn']);
    Route::get('bgreen_iot/get-device', [DeviceController::class, 'getDevice']);
    Route::post('bgreen_iot/insert-device', [DeviceController::class, 'insertDevice']);
    Route::put('bgreen_iot/update-device', [DeviceController::class, 'updateDevice']);
    Route::delete('bgreen_iot/delete-device', [DeviceController::class, 'deleteDevice']);
    #MQTT
    Route::post('bgreen_iot/send', [MqttController::class, 'sendMqtt']);

});
