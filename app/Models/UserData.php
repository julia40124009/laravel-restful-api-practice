<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 使用者帳號資料
class UserData extends Model
{
    protected $table = 'userdata';   // 資料表名稱
    protected $primaryKey = 'email';      // 主鍵
    public $incrementing = false;
    public $timestamps = false; // 因為我們沒有設定 created_at 或 updated_at 的欄位，不需要時間戳記
    protected $fillable =
        ['email','mobilephone','name','birthday','sex','height','weight'];
}
