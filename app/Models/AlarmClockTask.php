<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 鬧鐘
class AlarmClockTask extends Model
{
    protected $table = 'alarm_clock_task';   // 資料表名稱
    protected $primaryKey = 'id';      // 主鍵
    public $incrementing = true;
    public $timestamps = false; // 因為我們沒有設定 created_at 或 updated_at 的欄位，不需要時間戳記
    protected $fillable =
        ['id', 'sn', 'switch', 'email', 'start_time', 'start_week', 'repeat_week',
            'end_time', 'vertical_speed', 'horizontal_speed'];
}
