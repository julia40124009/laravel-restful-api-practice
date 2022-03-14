<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model
{
    protected $table = 'app_version';  // 資料表名稱
    protected $primaryKey = 'app_name';   // 主鍵
    public $incrementing = false;
    public $timestamps = false; // 因為我們沒有設定 created_at 或 updated_at 的欄位，不需要時間戳記
    protected $fillable =
        ['os_type', 'app_name', 'version', 'store_url', 'update_status'];
}
