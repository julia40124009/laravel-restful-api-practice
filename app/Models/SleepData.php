<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 睡眠資料
class SleepData extends Model
{
    protected $table = 'sleep_data';   // 資料表名稱
    protected $primaryKey = 'uid';      // 主鍵
    public $incrementing = true;
    public $timestamps = false; // 因為我們沒有設定 created_at 或 updated_at 的欄位，不需要時間戳記
    protected $fillable =
        ['uid','sn','mobilephone','sleep_status','datetime'];
}
