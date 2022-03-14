<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 使用者帳號資料
class Device extends Model
{
    protected $table = 'device_sn';  // 資料表名稱
    protected $primaryKey = 'did';   // 主鍵
    public $incrementing = true;
    public $timestamps = false; // 因為我們沒有設定 created_at 或 updated_at 的欄位，不需要時間戳記
    protected $fillable =
        ['did', 'sn', 'email', 'mobilephone', 'device_name'];
}
